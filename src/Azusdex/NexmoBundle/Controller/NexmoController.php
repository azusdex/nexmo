<?php
/**
 * Created by PhpStorm.
 * User: konstantin.khotski
 * Date: 5/3/2015
 * Time: 11:42 AM
 */
namespace Azusdex\NexmoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NexmoController extends Controller{

    public function accountBalanceAction() {
        $service = $this->get('nexmo.account');

        die(json_encode($service->getAccountBalance()));
    }
}