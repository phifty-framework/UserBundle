<?php
namespace UserBundle\Model\Mixin;

use Maghead\Schema\MixinDeclareSchema;
use UserBundle\Model\RoleSchema;

class UserInfoSchema extends MixinDeclareSchema
{
    public function schema($options = array())
    {
        if ( isset($options['UseAccount']) ) {
            $this->column( 'account' )
                ->varchar(16)
                ->label('帳號');
        }

        $this->column('confirmed')
            ->boolean()
            ->default(false)
            ->label('已確認');

        $this->column('email')
            ->varchar(80)
            ->label( _('E-mail') );

        $this->column('name')
            ->varchar(30)
            ->label('姓名')
            ;

        $this->column('phone')
            ->varchar(30)
            ->label('聯絡電話')
            ;


        if ( $options['MultiRole']) {
            $this->many('user_roles','UserBundle\\Model\\UserRoleSchema','user_id','id');
            $this->manyToMany('roles','user_roles','role');

        } else if ($options['CustomRole']) {
            $this->column( 'role')
                ->renderAs('SelectInput')
                ->refer(RoleSchema::class)
                ->validValues(function() {
                    $roles = new \UserBundle\Model\RoleCollection;
                    return $roles->toPairs('label','identity');
                })
                ->varchar(12)
                ->required()
                ->label( '角色' )
                ;
            $this->belongsTo('role','UserBundle\\Model\\RoleSchema','identity','role');
        } else {
            $this->column( 'role')
                ->varchar(12)
                ->validValues( array(
                    '管理員' => 'admin',
                    '一般使用者' => 'user',
                    '工作人員' => 'staff',
                    '訪客' => 'guest'
                ))
                ->default('user')
                ->renderAs('SelectInput')
                ->label( '角色' )
                ;
        }

        $this->column('company')
            ->varchar(64)
            ->label('Company Name')
            ;

    }
}



