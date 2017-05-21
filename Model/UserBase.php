<?php
namespace UserBundle\Model;

class UserBase  extends \Phifty\Model {
const schema_proxy_class = 'UserBundle\\Model\\UserSchemaProxy';
const collection_class = 'UserBundle\\Model\\UserCollection';
const model_class = 'UserBundle\\Model\\User';
const table = 'users';

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



    /**
     * Code block for message id parser.
     */
    private function __() {
            }
}
