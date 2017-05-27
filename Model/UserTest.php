<?php

namespace UserBundle\Model;

use Maghead\Testing\ModelTestCase;
use Maghead\Runtime\Config\FileConfigLoader;

class UserTest extends ModelTestCase
{
    public function config()
    {
        return FileConfigLoader::load('config/database.dev.yml');
    }

    public function models()
    {
        return [new UserSchema, new RoleSchema, new UserRoleSchema];
    }


    public function testCreateLoadAndDelete()
    {
        $ret = User::create([
            'account' => 'admin',
        ]);
        $this->assertResultSuccess($ret);

        $user = User::load($ret->key);
        $this->assertNotNull($user);
        $this->assertInstanceOf('UserBundle\\Model\\User', $user);

        $ret = $user->delete();
        $this->assertResultSuccess($ret);
    }

}
