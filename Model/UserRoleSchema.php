<?php

namespace UserBundle\Model;

use Maghead\Schema\DeclareSchema;

class UserRoleSchema extends DeclareSchema
{
    public function schema()
    {
        $this->column('user_id')
            ->integer()
            ->unsigned()
            ->required();

        $this->column('role_id')
            ->integer()
            ->unsigned()
            ->required();

        $cuser = kernel()->currentUser;

        // XXX: get current user model class to make link
        $this->belongsTo('user', $cuser->getModelClass() . 'Schema', 'id', 'user_id');
        $this->belongsTo('role', 'UserBundle\\Model\\RoleSchema', 'id', 'role_id');
    }
}
