<?php
namespace UserBundle;
use Kendo\Acl\DatabaseRules;

class AccessRules extends DatabaseRules
{
    public function build() {

        $this->resource('user')
            ->label('User Management');

        $this->resource('user_roles')
            ->label('User Role Management');

        $this->rule('admin','user','view',true)
            ->label('View User');

        $this->rule('admin','user','create',true)
            ->label('Create User');

        $this->rule('admin','user','update',true)
            ->label('Update User');

        $this->rule('admin','user','delete',true)
            ->label('Delete User');


        $this->rule('admin','user_roles','view',true)
            ->label('View User Roles');

        $this->rule('admin','user_roles','create',true)
            ->label('Create User Role');

        $this->rule('admin','user_roles','add_role',true)
            ->label('Add User Role');

        $this->rule('admin','user_roles','remove_role',true)
            ->label('Remove User Role');

        $this->rule('admin','user_roles','edit_permission',true)
            ->label('Edit Role Permissions');
    }
}



