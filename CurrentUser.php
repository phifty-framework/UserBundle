<?php

namespace UserBundle;

class CurrentUser extends \Phifty\Security\CurrentUser
{
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
