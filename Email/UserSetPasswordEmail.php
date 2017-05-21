<?php
namespace UserBundle\Email;

class UserSetPasswordEmail extends UserEmail
{

    public $format = 'text/html';

    /**
     * @var string template handle
     */
    public $templateHandle = 'user_set_password';

    public $title = '已設定新密碼';

    protected $password;

    public function __construct($arg, $password)
    {
        parent::__construct($arg);
        $this->setPassword($password);
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getArguments()
    {
        return array_merge(parent::getArguments(), [
            'password' => $this->password,
        ]);
    }

}

