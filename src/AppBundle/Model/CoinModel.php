<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 19:54
 */

namespace AppBundle\Model;

class CoinModel
{
    public static function getCoinsWorth($em)
    {
        $sql = "SELECT c.* FROM coin c ORDER BY worth DESC";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
