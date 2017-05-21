<?php
namespace UserBundle\Model;

class UserRole
extends \UserBundle\Model\UserRoleBase
{
    public function dataLabel()
    {
        if( $this->label )
            return $this->label;
        if( $this->identity )
            return ucfirst($this->identity);
        return $this->id;
    }

    public function dataKeyValue() {
        return $this->identity;
    }

    public function __toString()
    {
        return $this->identity;
    }
}
