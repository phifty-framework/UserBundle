<?php
namespace UserBundle\Model;

class UserRoleBase  extends \Phifty\Model {
const schema_proxy_class = 'UserBundle\\Model\\UserRoleSchemaProxy';
const collection_class = 'UserBundle\\Model\\UserRoleCollection';
const model_class = 'UserBundle\\Model\\UserRole';
const table = 'user_roles';

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



    /**
     * Code block for message id parser.
     */
    private function __() {
            }
}
