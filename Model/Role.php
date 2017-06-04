<?php
namespace UserBundle\Model;

class Role extends \UserBundle\Model\RoleBase
{
    public function dataLabel()
    {
        return $this->label;
    }

    public function beforeCreate($args)
    {
        if (!isset($args['label']) && isset($args['identity'])) {
            $args['label'] = $args['identity'];
        }
        return $args;
    }

    public function afterCreate()
    {
        if (class_exists('Kendo\\Model\\AccessControlCollection', true)) {
            $newRule = new \Kendo\Model\AccessControl;
            $rules = new \Kendo\Model\AccessControlCollection;
            $rules->where()
                ->equal('role', 'admin');
            foreach ($rules as $rule) {
                $data = $rule->getData();
                unset($data['id']);
                $data['role'] = $this->identity;
                $newRule->create($data);
            }
        }
    }

    public function afterDelete()
    {
        if (class_exists('Kendo\\Model\\AccessControlCollection', true)) {
            $rules = new \Kendo\Model\AccessControlCollection;
            $rules->where()
                ->equal('role', $this->identity);
            foreach ($rules as $rule) {
                $rule->delete();
            }
        }
    }


    public function __toString()
    {
        return $this->identity;
    }
}
