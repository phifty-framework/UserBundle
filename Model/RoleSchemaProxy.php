<?php
namespace UserBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class RoleSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'label',
  1 => 'identity',
  2 => 'description',
  3 => 'id',
);
    public static $column_hash = array (
  'label' => 1,
  'identity' => 1,
  'description' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'label',
  1 => 'identity',
  2 => 'description',
  3 => 'id',
);

    const schema_class = 'UserBundle\\Model\\RoleSchema';
    const collection_class = 'UserBundle\\Model\\RoleCollection';
    const model_class = 'UserBundle\\Model\\Role';
    const model_name = 'Role';
    const model_namespace = 'UserBundle\\Model';
    const primary_key = 'id';
    const table = 'roles';
    const label = 'Role';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'label' => array( 
      'name' => 'label',
      'attributes' => array( 
          'type' => 'varchar(32)',
          'isa' => 'str',
          'size' => 32,
          'label' => '標籤',
        ),
    ),
  'identity' => array( 
      'name' => 'identity',
      'attributes' => array( 
          'type' => 'varchar(12)',
          'isa' => 'str',
          'size' => 12,
          'required' => true,
          'unique' => true,
          'label' => 'Identity',
        ),
    ),
  'description' => array( 
      'name' => 'description',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'label' => '敘述',
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
  'label',
  'identity',
  'description',
);
        $this->primaryKey      = 'id';
        $this->table           = 'roles';
        $this->modelClass      = 'UserBundle\\Model\\Role';
        $this->collectionClass = 'UserBundle\\Model\\RoleCollection';
        $this->label           = 'Role';
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
        _('Role');
        _('標籤');
        _('Identity');
        _('敘述');
    }

}
