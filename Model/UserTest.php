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
}
