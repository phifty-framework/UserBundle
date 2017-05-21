<?php
namespace UserBundle\Action;
use ActionKit\RecordAction\CreateRecordAction;

class CreateUser extends CreateRecordAction
{
    public $recordClass = 'UserBundle\\Model\\User';

    public function __construct( $args = array(), $record = null, $currentUser = null ) 
    {
        $cUser = kernel()->currentUser;
        $this->recordClass = $cUser->getModelClass();
        return parent::__construct( $args, $record, $currentUser );
    }

    public function schema() 
    {
        $this->useRecordSchema();

        $cUser = kernel()->currentUser;

        if ( ! $cUser->hasRole('admin') ) {
            $this->filterOut('role','password');
        }

        $this->param('password1')
            ->renderAs('PasswordInput')
            ->label('密碼')
            ;
        $this->param('password2')
            ->renderAs('PasswordInput')
            ->label('密碼確認')
            ;
    }

    public function run()
    {
        $from      = $this->arg('from');

        $account   = trim($this->arg('account'));
        $email     = trim($this->arg('email'));
        $password1 = $this->arg('password1');
        $password2 = $this->arg('password2');

        if ( ! $account && ! $email ) {
            return $this->error( _('Please Enter Your Email Or Account.') );
        }

        $user = new \UserBundle\Model\User;

        if ( $account ) {
            $user->load(array('account' => $account));
        } else if ( $email ) {
            $user->load(array('email' => $email));
        }

        if ( $user->id ) {
            return $this->error( _('Duplicated Email or Account, Please Confirm.') );
        }

        if ( ! $password1 || ! $password2 ) {
            return $this->error( _('Please enter password.') );
        }

        if ( $password1 != $password2 ) {
            return $this->error( _('Password is not correct.') );
        }

        if ( strlen($password1) < 6 ) {
            return $this->error( _('Password should be more than 6 chars') );
        }

        $this->setArgument( 'password' , sha1( $password1 ) );
        return parent::run();
    }
}

