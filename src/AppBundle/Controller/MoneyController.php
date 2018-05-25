<?php
/**
 * Created by PhpStorm.
 * User: 11
 * Date: 25.05.2018
 * Time: 18:21
 */

namespace AppBundle\Controller;

use AppBundle\Model\MoneyModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MoneyController extends Controller
{
    /**
     * @Route("/spent-money", name="spent_money")
     */
    public function spentMoneyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cid = intval($request->request->get('cid'));
        $sum = intval($request->request->get('money'));

        $result = MoneyModel::spentMoney($em, $cid, $sum);

        return new JsonResponse(['result'=>$result]);
    }

    /**
     * @Route("/get-money-back", name="get_money_back")
     */
    public function getMoneyBackAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sum = intval($request->request->get('amount'));

        $res = MoneyModel::getMoneyBack($em, $sum);

        return new JsonResponse(['result'=>$res['result'], 'data'=>$res['data']]);
    }
}