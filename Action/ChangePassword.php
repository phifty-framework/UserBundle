<?php
namespace UserBundle\Action;
use ActionKit\RecordAction\UpdateRecordAction;

class ChangePassword extends UpdateRecordAction
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
        // if the current user is not admin, then
        // we should show the current_password field
        $cUser = kernel()->currentUser;
        if ( ! $cUser->hasRole('admin') ) {
            $this->param('current_password')
                ->label('Current Password')
                ->renderAs('PasswordInput');
        }

        $this->param('password1')
                ->label('New Password')
                ->renderAs('PasswordInput');

        $this->param('password2')
                ->label('New Password Confirm')
                ->renderAs('PasswordInput');
    }

    public function run()
    {
        $cUser = kernel()->currentUser;
        $password1 = $this->arg('password1');
        $password2 = $this->arg('password2');

        if ( ! $cUser->hasRole('admin') ) {
            // validate current password here.
            $currentPassword = $this->arg('current_password');
            if ( $this->record->password != sha1($currentPassword) ) {
                return $this->error( _('Incorrect Current Password.') );
            }
        }

        if( $password1 && $password2 ) {
            if ( $password1 != $password2 ) {
                return $this->error( _('Password is not match.') );
            }
            if( strlen($password1) < 6 )
                return $this->error( _('Password should be more than 6 chars') );

            $this->setArgument( 'password' , sha1( $password1 ) );

            $ret = $this->record->update(array( 'password' => sha1($password1) ));
            if( $ret->success )
                return $this->success( _('Password is changed.') );
            else 
                return $this->error( $ret->message );
        }
        return $this->error( _('Error, Can not change password.') );
    }

}

