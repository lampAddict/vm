<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Wallet;
use AppBundle\Model\VMGoodsModel;
use AppBundle\Model\WalletModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

//        /* @var $wallet \AppBundle\Entity\Wallet */
//        $wallet = new Wallet();

        $walletData = WalletModel::getAllWalletsData($em);
        $goodsData = VMGoodsModel::getAllGoods($em);

        return $this->render('default/index.html.twig', [
            'goods' => $goodsData,
            'user_wallet' => $walletData['user_wallet'],
            'vm_wallet' => $walletData['vm_wallet']
        ]);
    }
}
