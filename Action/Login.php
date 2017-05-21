<?php
namespace UserBundle\Action;
use ActionKit\Action;

class Login extends Action
{
    public $user;

    public function run()
    {
        $cUser = kernel()->currentUser;
        $userModelClass = $cUser->getModelClass();
        $account   = trim($this->arg('account'));
        $email     = trim($this->arg('email'));

        $redirect = $this->arg('redirect');
        $password = $this->arg('password');

        if ( ! $account && ! $email ) {
            return $this->error(_('請輸入帳號或 Email'));
        }

        $this->user = new $userModelClass;

        if ( $account ) {
            $ret = $this->user->load(array('account' => $account));
        } else if ( $email ) {
            $ret = $this->user->load(array('email' => $email));
        } else {
            return $this->error(_('無法登入，請輸入帳號或密碼'));
        }

        // $ret = $this->user->find(array( 'account' => $account ) );

        if ( ! $ret->success || ! $this->user->id ) {
            return $this->error(_('錯誤的帳號或密碼'));
        }

        if ($this->user->password != sha1($password) ) {
            return $this->error(_('錯誤的密碼'));
        }
        if (!$this->user->confirmed) {
            return $this->error(_('尚未確認 Email'));
        }
        $cUser->setRecord($this->user);
        $this->success(_('登入成功'));
        if ( $redirect ) {
            return $this->redirect( $redirect );
        }
        return $this->redirect( '/bs' );
    }
}

