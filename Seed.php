<?php
namespace UserBundle;
use UserBundle\Utils;

class Seed 
{
    public static function seed()
    {
        $role = new \UserBundle\Model\Role;


        $role->create(array(
            'identity' => 'admin',
            'label' => 'Admin',
        ));
        $role->create(array(
            'identity' => 'staff',
            'label' => 'Staff',
        ));
        $role->create(array(
            'identity'    => 'user',
            'label'       => 'User',
        ));
        $role->create(array(
            'identity'    => 'guest',
            'label'       => 'Guest',
        ));

        /*
        $user = new \UserBundle\Model\User;
        $ret = $user->create(array(
            'account'    => 'guest',
            'email'      => 'guest01@localhost',
            'password' => sha1('guest'),
            'address'    => 'User Address',
            'confirmed'  => true,
        ));
        if( ! $ret->success )
            throw $ret->exception;
        $user->addRole('guest');
        */

        $password = Utils::generate_password(6);
        $ret = $user->create(array( 
            'account'    => 'admin',
            'email'      => 'admin@localhost',
            'password'   => sha1($password),
            'remark'     => $password,
            'confirmed'  => true,
        ));
        if ( ! $ret->success ) {
            throw $ret->exception;
        }
        $user->addRole('admin');
    }
}

