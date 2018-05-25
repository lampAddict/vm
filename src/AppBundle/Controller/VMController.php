<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 17:16
 */

namespace AppBundle\Controller;

use AppBundle\Model\VMGoodsModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class VMController extends Controller
{
    /**
     * @Route("/buy", name="buy")
     */
    public function buyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $gid = intval($request->request->get('goods'));

        $result = VMGoodsModel::buyGoods($em, $gid);

        return new JsonResponse(['result'=>$result]);
    }
}