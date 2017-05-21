<?php
namespace UserBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class UserRoleSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'user_id',
  1 => 'role_id',
  2 => 'id',
);
    public static $column_hash = array (
  'user_id' => 1,
  'role_id' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'user_id',
  1 => 'role_id',
  2 => 'id',
);

    const schema_class = 'UserBundle\\Model\\UserRoleSchema';
    const collection_class = 'UserBundle\\Model\\UserRoleCollection';
    const model_class = 'UserBundle\\Model\\UserRole';
    const model_name = 'UserRole';
    const model_namespace = 'UserBundle\\Model';
    const primary_key = 'id';
    const table = 'user_roles';
    const label = 'UserRole';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'user_id' => array( 
      'name' => 'user_id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'required' => true,
        ),
    ),
  'role_id' => array( 
      'name' => 'role_id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'required' => true,
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
  'user_id',
  'role_id',
);
        $this->primaryKey      = 'id';
        $this->table           = 'user_roles';
        $this->modelClass      = 'UserBundle\\Model\\UserRole';
        $this->collectionClass = 'UserBundle\\Model\\UserRoleCollection';
        $this->label           = 'UserRole';
        $this->relations       = array( 
  'user' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'UserBundle\\Model\\UserRoleSchema',
      'self_column' => 'user_id',
      'foreign_schema' => 'UserBundle\\Model\\UserSchema',
      'foreign_column' => 'id',
    ),
)),
  'role' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'UserBundle\\Model\\UserRoleSchema',
      'self_column' => 'role_id',
      'foreign_schema' => 'UserBundle\\Model\\RoleSchema',
      'foreign_column' => 'id',
    ),
)),
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }

    /**
     * Code block for message id parser.
     */
    private function __() {
        _('UserRole');
    }

}
