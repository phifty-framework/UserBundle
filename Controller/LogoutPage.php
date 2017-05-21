<?php

namespace UserBundle\Controller;

use Phifty\Controller;

class LogoutPage extends \Phifty\Controller
{
    function indexAction()
    {
        return $this->redirect('/bs/login');

        # create a page with logout message and go back to mainpage button
        return $this->render('@UserBundle/logout.html');
    }
}
