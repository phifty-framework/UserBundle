<?php
namespace UserBundle\Model;

class RoleBase  extends \Phifty\Model {
const schema_proxy_class = 'UserBundle\\Model\\RoleSchemaProxy';
const collection_class = 'UserBundle\\Model\\RoleCollection';
const model_class = 'UserBundle\\Model\\Role';
const table = 'roles';

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



    /**
     * Code block for message id parser.
     */
    private function __() {
            }
}
