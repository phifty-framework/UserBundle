<?php
namespace UserBundle\Action;
use ActionKit\Action;

class Login extends Action
{
    protected $user;

    protected $shouldValidateEmailConfirmation = false;

    protected $loginBy = 'account';

    protected $enableCSRFToken = false;

    public function findUserByEmailOrAccount($email, $account)
    {
        $cUser = kernel()->currentUser;
        $userModelClass = $cUser->getModelClass();
        $user = new $userModelClass;
        if ($account) {
            $ret = $user->load(['account' => $account]);
        } else if ( $email ) {
            $ret = $user->load(['email' => $email]);
        }
        if ($ret->error) {
            return null;
        }
        return $user;
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

        if (!$this->user->id ) {
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

        $log = new ActionLog;
        $log->create([
            'action'       => $this->description(),
            'action_class' => get_class($this),
            'message'      => $this->describe(),
            'user_id'      => $currentUser->id,
            // 'data'         => yaml_emit($this->args),
        ]);

        $csrfToken = kernel()->actionService['csrf_token_new'];
        @setcookie('csrf', $csrfToken->hash, 0, '/');

        if ($redirect) {
            return $this->redirect($redirect);
        }
        return $this->redirect('/bs');
    }
}
