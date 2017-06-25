<?php

namespace UserBundle\Action;

use WebAction\RecordAction\CreateRecordAction;
use WebAction\ActionDescriptor;
use UserBundle\Model\User;

class CreateUser extends CreateRecordAction implements ActionDescriptor
{
    public $recordClass = User::class;

    public function __construct($args = array(), $record = null, $currentUser = null)
    {
        $cUser = kernel()->currentUser;
        $this->recordClass = $cUser->getModelClass();
        return parent::__construct($args, $record, $currentUser);
    }

    public function describe()
    {
        $currentUser = kernel()->currentUser;
        $record = $this->getRecord();
        return sprintf("%s (%s) 建立帳號 %s (%s)",
            $currentUser->name, $currentUser->account,
            $record->name,
            $record->account);
    }

    public function description()
    {
        return '建立帳號';
    }

    public function schema()
    {
        $this->useRecordSchema();

        $cUser = kernel()->currentUser;

        if (! $cUser->hasRole('admin')) {
            $this->filterOut('role', 'password');
        }

        // override account attributes
        $this->param('account')
            ->required()
            ->validator(function ($value) {
                if (preg_match('/\W/', $value)) {
                    return [false, "帳號不可使用英文、數字、底線之外的字元。"];
                }
                if (strlen($value) < 3) {
                    return [false, "帳號名稱長度不足，請使用三個以上的字元。"];
                }
                return true;
            });

        $this->param('email')
            ->required()
            ->validator(function ($value) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return [false, "不合法的 E-mail"];
                }
                return true;
            });


        $this->param('password1')
            ->renderAs('PasswordInput')
            ->label('密碼')
            ;
        $this->param('password2')
            ->renderAs('PasswordInput')
            ->label('密碼確認')
            ;


        $this->param('set_password')
            ->label('密碼設定')
            ;
    }

    /**
     * Validate the account identitifier
     *
     * @param string $account
     *
     * @return true on success, string on error
     */
    public function validateAccount($account)
    {
        if (preg_match('/\W/', $account)) {
            return _('不合法的帳號字元。');
        }
        if (strlen($account) < 3) {
            return _('帳號長度必須為三個字元以上。');
        }
        return true;
    }

    public function tryLoadUser($account, $email, $preferAccount = true)
    {
        if (! $account && ! $email) {
            return _('請輸入帳號或 E-mail');
        }



        $user = new User;

        if ($preferAccount && $account) {
            $user->load(array('account' => $account));
            if ($user->id) {
                $this->invalidField('account', '重複的帳號。');
                return _('這個帳號已經被使用囉。');
            }
        } elseif ($email) {
            $user->load(array('email' => $email));
            if ($user->id) {
                $this->invalidField('email', '重複的帳號。');
                return _('這個 E-mail 地址已經被使用囉。');
            }
        } else {
            return _('輸入資料錯誤。');
        }
        return true;
    }
    
    public function successMessage($ret)
    {
        return _('成功建立使用者資料。');
    }

    public function run()
    {
        $from      = $this->arg('from');

        $account   = trim($this->arg('account'));
        $email     = trim($this->arg('email'));
        $password1 = $this->arg('password1');
        $password2 = $this->arg('password2');

        if (! $account && ! $email) {
            return $this->error(_('Please Enter Your Email Or Account.'));
        }

        $ret = $this->tryLoadUser($account, $email);
        if (true !== $ret) {
            if ($account) {
                $this->invalidField('account', $ret);
            } elseif ($email) {
                $this->invalidField('email', $ret);
            }
            return $this->error($ret);
        }

        $ret = $this->validateAccount($account);
        if (true !== $ret) {
            $this->invalidField('account', $ret);
            return $this->error($ret);
        }

        $plainPassword = null;
        if ($setPasswordBy = $this->arg('set_password')) {
            if ($ret = $this->setPasswordArgumentHashBy($setPasswordBy)) {
                list($success, $result) = $ret;
                if ($success === false) {
                    return $this->error($result);
                } else {
                    $plainPassword = $result;
                }
            }
        }

        $ret = parent::run();

        if ($setPasswordBy = $this->arg('set_password')) {
            if ($setPasswordBy === "email" && $plainPassword) {
                // Generate a new password and send the password to the user
                $user = $this->getRecord();
                $email = new UserSetPasswordEmail($user, $plainPassword);
                $email->send();
            }
        }

        return parent::run();
    }
}
