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
        $sql = "SELECT vmg.id, vmg.num, g.name, g.price FROM vm_goods vmg LEFT JOIN goods g ON vmg.gid = g.id";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $goods = [];
        foreach ($data as $d){
            $goods[] = [ 'name'=>$d['name'], 'price'=>$d['price'], 'num'=>$d['num'] ];
        }

        return $goods;
    }

}