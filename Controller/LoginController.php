<?php
namespace UserBundle\Controller;

use UserBundle\UserBundle;
use UserBundle\Action\Login;
use Phifty\Controller;
use AdminUI\AdminUI;

class LoginController extends Controller
{
    protected function getTemplateArgs()
    {
        $request = $this->getRequest();
        $bundle = UserBundle::getInstance();

        $action = new Login;
        $goto = $this->request->param('f'); /* get both from POST and GET */
        return [
            'goto' => $goto,
            'action' => $action,
            'Bundle' => $bundle
        ];
    }

    public function indexAction()
    {
        $adminUI = AdminUI::getInstance();
        $loginPageTemplate = $adminUI->getLoginPageTemplate();
        return $this->render($loginPageTemplate, $this->getTemplateArgs());
    }

    public function modalAction()
    {
        $adminUI = AdminUI::getInstance();
        $loginModalTemplate = $adminUI->getLoginModalTemplate();
        return $this->render($loginModalTemplate, $this->getTemplateArgs());
    }
}
