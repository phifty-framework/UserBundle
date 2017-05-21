<?php
namespace UserBundle\Controller;
use Phifty\Controller;

class LogoutController extends Controller
{
    function indexAction()
    {
        $logout = new \UserBundle\Action\Logout;
        $logout->run();
    }
}

