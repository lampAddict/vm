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
}