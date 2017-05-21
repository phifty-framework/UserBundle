<?php

namespace UserBundle\Action;
use ActionKit\RecordAction\DeleteRecordAction;

class DeleteUser extends DeleteRecordAction
{
    public $recordClass = 'UserBundle\\Model\\User';

    public function __construct( $args = array(), $record = null, $currentUser = null ) 
    {
        $cUser = kernel()->currentUser;
        $this->recordClass = $cUser->getModelClass();
        return parent::__construct( $args, $record, $currentUser );
    }

    public function run()
    {
        $cuser = kernel()->currentUser;
        if ( ! $cuser->isLogged() || ! $cuser->hasRole('admin') ) {
            return $this->error( _('Permission denied.') );
        }
        return parent::run();
    }

}

