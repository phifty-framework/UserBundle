<?php

namespace UserBundle\Model;

use Maghead\Testing\ModelTestCase;
use Maghead\Runtime\Config\FileConfigLoader;

class RoleTest extends ModelTestCase
{
    public function config()
    {
        return FileConfigLoader::load('config/database.dev.yml');
    }

    public function models()
    {
        return [new RoleSchema];
    }

    public function testLoadOrCreate()
    {
        $role = Role::loadOrCreate(['identity' => 'admin'], 'identity');
        $this->assertNotNull($role);
        $this->assertInstanceOf('UserBundle\\Model\\Role', $role);
    }
}
