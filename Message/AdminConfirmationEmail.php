<?php
namespace UserBundle\Message;

use EmailBundle\BaseEmail;

class AdminConfirmationEmail extends BaseEmail
{
    public $format = 'text/html';
    public $templateHandle = 'admin_confirmation';

    public function __construct($user)
    {
        $bundle = kernel()->bundle('UserBundle');
        $this->useModelTemplate = $bundle->config('UseModelTemplate');

        parent::__construct();
        $this['user'] = $user;
        $this->setSubject( __('新的使用者註冊: %1', $user->name ?: $user->email ));
        $this->setTemplate( '@UserBundle/email/zh_TW/admin_confirmation.html' );
    }

}



