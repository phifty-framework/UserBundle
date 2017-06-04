<?php
namespace UserBundle\Controller;
use Phifty\Routing\Controller;

class LogoutController extends Controller
{
    function indexAction()
    {
        $logout = new \UserBundle\Action\Logout;
        $logout->run();
    }
}

