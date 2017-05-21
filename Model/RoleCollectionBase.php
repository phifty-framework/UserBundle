<?php
namespace UserBundle\Model;

class RoleCollectionBase  extends \LazyRecord\BaseCollection {
const schema_proxy_class = '\\UserBundle\\Model\\RoleSchemaProxy';
const model_class = '\\UserBundle\\Model\\Role';
const table = 'roles';




    /**
     * Code block for message id parser.
     */
    private function __() {
            }
}
