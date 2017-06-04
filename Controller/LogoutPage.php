<?php

namespace UserBundle\Controller;

use Phifty\Routing\Controller;

class LogoutPage extends \Phifty\Routing\Controller
{
    function indexAction()
    {
        return $this->redirect('/bs/login');

        # create a page with logout message and go back to mainpage button
        return $this->render('@UserBundle/logout.html.twig');
    }
}
