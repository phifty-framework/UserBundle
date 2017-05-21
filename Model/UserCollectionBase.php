<?php
namespace UserBundle\Model;

class UserCollectionBase  extends \LazyRecord\BaseCollection {
const schema_proxy_class = '\\UserBundle\\Model\\UserSchemaProxy';
const model_class = '\\UserBundle\\Model\\User';
const table = 'users';




    /**
     * Code block for message id parser.
     */
    private function __() {
            }
}
