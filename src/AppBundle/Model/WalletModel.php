<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 15:59
 */

namespace AppBundle\Model;

class WalletModel
{
    public static function getAllWalletsData($em)
    {
        $sql = "SELECT w.id, w.wtype, w.num, c.worth FROM wallet w LEFT JOIN coin c ON w.cid = c.id";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $vm_wallet = [];
        $user_wallet = [];
        foreach ($data as $d){
            if( $d['wtype'] == 0 ){
                $vm_wallet[] = [ 'worth'=>$d['worth'], 'num'=>$d['num'] ];
            }
            else{
                $user_wallet[] = [ 'worth'=>$d['worth'], 'num'=>$d['num'] ];
            }
        }

        return ['user_wallet'=>$user_wallet, 'vm_wallet'=>$vm_wallet];
    }
}