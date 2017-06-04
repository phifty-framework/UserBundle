<?php
namespace UserBundle\Action;
use ActionKit\Action;

class Login extends Action
{
    protected $user;

    protected $shouldValidateEmailConfirmation = false;

    protected $loginBy = 'account';

    protected $enableCSRFToken = false;

    public function findUserByEmailOrAccount($email, $account = null)
    {
        $cUser = kernel()->currentUser;
        $userModelClass = $cUser->getModelClass();
        $userModelClass;
        if ($account) {
            return $userModelClass::load(['account' => $account]);
        } else {
            return $userModelClass::load(['email' => $email]);
        }
    }

    public function run()
    {
        $currentUser = kernel()->currentUser;
        $userModelClass = $currentUser->getModelClass();
        $account   = trim($this->arg('account'));
        $email     = trim($this->arg('email'));

        $redirect = $this->arg('redirect');
        $password = $this->arg('password');

        if (! $account && ! $email) {
            return $this->error(_('請輸入帳號或 Email'));
        }

        $this->user = $this->findUserByEmailOrAccount($email, $account);
        if (!$this->user) {
            return $this->error(_('無法登入，無此使用者'));
        }

        if (!$this->user->hasKey()) {
            return $this->error(_('錯誤的帳號或 E-mail'));
        }

        if (!$this->user->matchPassword($password)) {
            return $this->error(_('錯誤的密碼'));
        }

        if ($this->shouldValidateEmailConfirmation) {
            if (!$this->user->confirmed) {
                return $this->error(_('尚未確認 Email'));
            }
        }

        $currentUser->setRecord($this->user);

        $this->success(_('登入成功'));

        $csrfToken = kernel()->actionService['csrf_token_new'];
        @setcookie('csrf', $csrfToken->hash, 0, '/');

        if ($redirect) {
            return $this->redirect($redirect);
        }
        return $this->redirect('/bs');
    }
}
