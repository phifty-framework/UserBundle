<?php
namespace UserBundle\Model;

use Maghead\Schema\DeclareSchema;
use UserBundle\Model\Mixin\UserInfoSchema;

class UserSchema extends DeclareSchema
{
    public function schema()
    {
        $bundle = kernel()->bundle('UserBundle');

        /**
         * sha1 encrypted password column
         */
        $this->column('password')
            ->renderable(false)
            ->varchar(128)
            ->label('密碼')
            ;

        $this->column('auth_token')
            ->varchar(128)
            ->label('驗證密碼')
            ->renderable(false)
            ;

        $this->mixin(UserInfoSchema::class, [
            'UseAccount' => $bundle->config('UseAccount'),
            'MultiRole' => $bundle->config('MultiRole'),
            'CustomRole' => $bundle->config('CustomRole'),
        ]);

        $this->column('receive_email')
            ->boolean()
            ->default(true)
            ->label('接收 E-mail')
            ->renderAs('CheckboxInput')
            ;

        $this->column('receive_sms')
            ->boolean()
            ->default(true)
            ->label('接收 SMS')
            ->renderAs('CheckboxInput')
            ;

        $this->column('remark')
            ->text()
            ->label('備註')
            ->renderAs('TextareaInput', [ 'rows' => 3, 'cols' => 40 ])
            ;

        // $this->seeds('UserBundle::Seed');
    }
}
