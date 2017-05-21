<?php
namespace UserBundle\Model;
use Maghead\Schema\DeclareSchema;

class UserRoleSchema extends Schema
{
    public function schema()
    {
        $this->column('user_id')
            ->integer()
            ->required();

        $this->column('role_id')
            ->integer()
            ->required();

        $cuser = kernel()->currentUser;

        // XXX: get current user model class to make link
        $this->belongsTo('user', $cuser->getModelClass() . 'Schema','id','user_id');
        $this->belongsTo('role', 'UserBundle\\Model\\RoleSchema','id','role_id');
    }
}



