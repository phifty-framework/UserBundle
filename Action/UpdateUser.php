<?php
namespace UserBundle\Action;

use ActionKit\RecordAction\UpdateRecordAction;

class UpdateUser extends UpdateRecordAction
{
    public $recordClass = 'UserBundle\\Model\\User';

    public function __construct($args = array(), $record = null, $currentUser = null)
    {
        $cUser = kernel()->currentUser;
        $this->recordClass = $cUser->getModelClass();
        return parent::__construct($args, $record, $currentUser);
    }

    public function schema()
    {
        $this->useRecordSchema();
        $this->param('account')
            ->immutable();

        $cUser = kernel()->currentUser;
        if (! $cUser->hasRole('admin')) {
            $this->filterOut('role', 'password');
        }
    }
}
