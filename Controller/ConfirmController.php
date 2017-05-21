<?php
namespace UserBundle\Controller;
use Phifty\Controller;
use UserBundle\Model\User;

class ConfirmController extends Controller
{
    public function indexAction() {
        $token = $this->request->param('token');

        $bundle = \UserBundle\UserBundle::getInstance();
        $template = $bundle->config('confirmation.template') ?: '@UserBundle/confirmed.html';

        $user = User::load(['auth_token' => $token]);

        // if it's a valid token
        if ($user->id) {
            $ret = $user->update(array('confirmed' => true));
            return $this->render($template, array(
                'success' => true,
                'title' => _('電子郵件確認成功'),
                'desc' => _('謝謝您，您已經可以開始登入使用。'),
            ));
        } else {
            return $this->render($template, array(
                'success' => false,
                'title' => _('電子郵件確認失敗'),
                'desc' => _('請聯絡管理員'),
            ));
        }
    }
}
