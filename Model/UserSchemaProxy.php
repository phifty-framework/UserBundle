<?php
namespace UserBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class UserSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'password',
  1 => 'auth_token',
  2 => 'account',
  3 => 'confirmed',
  4 => 'email',
  5 => 'name',
  6 => 'phone',
  7 => 'role',
  8 => 'company',
  9 => 'receive_email',
  10 => 'receive_sms',
  11 => 'remark',
  12 => 'id',
);
    public static $column_hash = array (
  'password' => 1,
  'auth_token' => 1,
  'account' => 1,
  'confirmed' => 1,
  'email' => 1,
  'name' => 1,
  'phone' => 1,
  'role' => 1,
  'company' => 1,
  'receive_email' => 1,
  'receive_sms' => 1,
  'remark' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
  0 => 'UserBundle\\Model\\Mixin\\UserInfoSchema',
);
    public static $column_names_include_virtual = array (
  0 => 'password',
  1 => 'auth_token',
  2 => 'account',
  3 => 'confirmed',
  4 => 'email',
  5 => 'name',
  6 => 'phone',
  7 => 'role',
  8 => 'company',
  9 => 'receive_email',
  10 => 'receive_sms',
  11 => 'remark',
  12 => 'id',
);

    const schema_class = 'UserBundle\\Model\\UserSchema';
    const collection_class = 'UserBundle\\Model\\UserCollection';
    const model_class = 'UserBundle\\Model\\User';
    const model_name = 'User';
    const model_namespace = 'UserBundle\\Model';
    const primary_key = 'id';
    const table = 'users';
    const label = 'User';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'password' => array( 
      'name' => 'password',
      'attributes' => array( 
          'type' => 'varchar(128)',
          'isa' => 'str',
          'renderable' => false,
          'size' => 128,
          'label' => '密碼',
        ),
    ),
  'auth_token' => array( 
      'name' => 'auth_token',
      'attributes' => array( 
          'type' => 'varchar(128)',
          'isa' => 'str',
          'size' => 128,
          'label' => '驗證密碼',
          'renderable' => false,
        ),
    ),
  'account' => array( 
      'name' => 'account',
      'attributes' => array( 
          'type' => 'varchar(16)',
          'isa' => 'str',
          'size' => 16,
          'label' => '帳號',
        ),
    ),
  'confirmed' => array( 
      'name' => 'confirmed',
      'attributes' => array( 
          'type' => 'boolean',
          'isa' => 'bool',
          'default' => false,
          'label' => '已確認',
        ),
    ),
  'email' => array( 
      'name' => 'email',
      'attributes' => array( 
          'type' => 'varchar(80)',
          'isa' => 'str',
          'size' => 80,
          'label' => '電子郵件',
        ),
    ),
  'name' => array( 
      'name' => 'name',
      'attributes' => array( 
          'type' => 'varchar(30)',
          'isa' => 'str',
          'size' => 30,
          'label' => '姓名',
        ),
    ),
  'phone' => array( 
      'name' => 'phone',
      'attributes' => array( 
          'type' => 'varchar(30)',
          'isa' => 'str',
          'size' => 30,
          'label' => '聯絡電話',
        ),
    ),
  'role' => array( 
      'name' => 'role',
      'attributes' => array( 
          'type' => 'varchar(12)',
          'isa' => 'str',
          'size' => 12,
          'validValues' => array( 
              '管理員' => 'admin',
              '一般使用者' => 'user',
              '工作人員' => 'staff',
              '訪客' => 'guest',
            ),
          'default' => 'user',
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
            ),
          'label' => '角色',
        ),
    ),
  'company' => array( 
      'name' => 'company',
      'attributes' => array( 
          'type' => 'varchar(64)',
          'isa' => 'str',
          'size' => 64,
          'label' => 'Company Name',
        ),
    ),
  'receive_email' => array( 
      'name' => 'receive_email',
      'attributes' => array( 
          'type' => 'boolean',
          'isa' => 'bool',
          'default' => true,
          'label' => '接收 E-mail',
          'renderAs' => 'CheckboxInput',
          'widgetAttributes' => array( 
            ),
        ),
    ),
  'receive_sms' => array( 
      'name' => 'receive_sms',
      'attributes' => array( 
          'type' => 'boolean',
          'isa' => 'bool',
          'default' => true,
          'label' => '接收 SMS',
          'renderAs' => 'CheckboxInput',
          'widgetAttributes' => array( 
            ),
        ),
    ),
  'remark' => array( 
      'name' => 'remark',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'label' => '備註',
          'renderAs' => 'TextareaInput',
          'widgetAttributes' => array( 
              'rows' => 3,
              'cols' => 40,
            ),
        ),
    ),
  'id' => array( 
      'name' => 'id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'primary' => true,
          'autoIncrement' => true,
        ),
    ),
);
        $this->columnNames     = array( 
  'id',
  'password',
  'auth_token',
  'receive_email',
  'receive_sms',
  'remark',
);
        $this->primaryKey      = 'id';
        $this->table           = 'users';
        $this->modelClass      = 'UserBundle\\Model\\User';
        $this->collectionClass = 'UserBundle\\Model\\UserCollection';
        $this->label           = 'User';
        $this->relations       = array( 
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }

    /**
     * Code block for message id parser.
     */
    private function __() {
        _('User');
        _('密碼');
        _('驗證密碼');
        _('帳號');
        _('已確認');
        _('電子郵件');
        _('姓名');
        _('聯絡電話');
        _('角色');
        _('Company Name');
        _('接收 E-mail');
        _('接收 SMS');
        _('備註');
    }

}
