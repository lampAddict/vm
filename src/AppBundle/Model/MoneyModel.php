<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 18:25
 */

namespace AppBundle\Model;

use AppBundle\Config\Config;

class MoneyModel
{
    public static function spentMoney($em, $cid, $sum)
    {
        $sql = "SELECT w.*, c.worth FROM wallet w LEFT JOIN coin c ON w.cid = c.id WHERE w.cid = '" . $cid . "'  AND wtype = '" . Config::USER_WALLET . "' LIMIT 1";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $d = $data[0];

        if( $d['num'] > 0 && $d['worth'] == $sum ){

            //decrease num of user corresponding coins
            $sql = "UPDATE wallet w SET num = " . ($d['num'] - 1) . " WHERE w.id = '" . $d['id'] . "'";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();

            //update sum of cash in vm
            /* @var $money \AppBundle\Entity\MoneySpent */
            $money = $em->getRepository('AppBundle:MoneySpent')->findOneBy(['id'=>1]);
            $money->setSum( $money->getSum() + $sum );

            $em->persist($money);
            $em->flush();
        }
        else{
            return false;
        }

        return true;
    }

    public static function getCash($em)
    {
        /* @var $money \AppBundle\Entity\MoneySpent */
        $money = $em->getRepository('AppBundle:MoneySpent')->findOneBy(['id'=>1]);

        return $money->getSum();
    }

    public static function getMoneyBack($em, $sum)
    {
        /* @var $money \AppBundle\Entity\MoneySpent */
        $money = $em->getRepository('AppBundle:MoneySpent')->findOneBy(['id'=>1]);

        if( $sum > 0 && $sum <= $money->getSum() ){

            //split sum by coins worth
            $cworth = CoinModel::getCoinsWorth($em);

            $coins = [];
            $sum_split = $sum;
            foreach ($cworth as $c){
                $coins[] = ['cid'=>$c['id'], 'num'=>intval($sum_split / (int)$c['worth'])];
                $sum_split = $sum_split % (int)$c['worth'];
                if( $sum_split == 0 )break;
            }

            self::updateCoinsAmount($em, $coins);

            //update sum of cash in vm
            $money->setSum( $money->getSum() - $sum );

            $em->persist($money);
            $em->flush();

            return ['result'=>true, 'data'=>$coins];
        }

        return ['result'=>false, 'data'=>[]];
    }

    private static function updateCoinsAmount($em, $coins)
    {
        //update number of coins in user wallet
        $cid = [];
        $sql =  "UPDATE wallet w SET ";
        foreach ($coins as $c){
            if( $c['num'] > 0 ){
                $sql .= "w.num = IF(cid='" . $c['cid'] . "', (w.num + " . $c['num'] . "), w.num), ";
            }
            $cid[] = $c['cid'];
        }
        $sql = rtrim($sql, ', ');
        $sql .= ' WHERE cid IN ('.join(',',$cid).') AND  wtype = ' . Config::USER_WALLET;

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();

        //update number of coins in vm wallet
        $cid = [];
        $sql =  "UPDATE wallet w SET ";
        foreach ($coins as $c){
            if( $c['num'] > 0 ){
                $sql .= "w.num = IF(cid='" . $c['cid'] . "', (w.num - " . $c['num'] . "), w.num), ";
            }
            $cid[] = $c['cid'];
        }
        $sql = rtrim($sql, ', ');
        $sql .= ' WHERE cid IN ('.join(',',$cid).') AND  wtype = ' . Config::VM_WALLET;

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
    }
}