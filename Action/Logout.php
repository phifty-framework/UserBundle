<?php

namespace UserBundle\Action;

use ActionKit;

class Logout extends \ActionKit\Action
{
    public function run()
    {
        // XXX: get current user model class and do authentication here,
        //      we also need to use the config from plugin.
        $cUser = kernel()->currentUser;

        if ($cUser->isLogged()) {
            if ($bundle = kernel()->bundle('LogPlugin')) {
                $log = new \LogPlugin\Model\Log;
                $log->create(array(
                    'actor_id' => $cUser->id,
                    'message' => '使用者 ' . $cUser->account . ' 登出成功',
                ));
            }
            $cUser->logout();
        }

        $this->success(_('Log out successed.'));
        $redirect = $this->arg('redirect');
        if ($redirect) {
            return $this->redirect($redirect);
        }
        return $this->redirect('/bs');
    }
}
