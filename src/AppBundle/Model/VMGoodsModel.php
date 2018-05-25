<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 16:18
 */

namespace AppBundle\Model;

class VMGoodsModel
{
    public static function getAllGoods($em)
    {
        $sql = "SELECT vmg.id, vmg.num, g.id as gid, g.name, g.price FROM vm_goods vmg LEFT JOIN goods g ON vmg.gid = g.id";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $goods = [];
        foreach ($data as $d){
            $goods[] = [ 'name'=>$d['name'], 'price'=>$d['price'], 'num'=>$d['num'], 'gid'=>$d['gid'] ];
        }

        return $goods;
    }

    public static function buyGoods($em, $gid)
    {
        $sql = "SELECT vmg.num, g.price FROM vm_goods vmg LEFT JOIN goods g ON vmg.gid = g.id WHERE g.id = '" . $gid . "' LIMIT 1";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $d = $data[0];

        if( $d['num'] > 0 ){

            /* @var $money \AppBundle\Entity\MoneySpent */
            $money = $em->getRepository('AppBundle:MoneySpent')->findOneBy(['id'=>1]);
            $cash = $money->getSum();

            if( $d['price'] <= $cash ){

                //decrease num of corresponding vm goods
                $sql = "UPDATE vm_goods vm SET num = " . ($d['num'] - 1) . " WHERE vm.gid = '" . $gid . "'";
                $stmt = $em->getConnection()->prepare($sql);
                $stmt->execute();

                //decrease vm cash amount
                $money->setSum( $cash - $d['price'] );

                $em->persist($money);
                $em->flush();

                return true;
            }
        }

        return false;
    }

}