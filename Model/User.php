<?php
namespace UserBundle\Model;

use Phifty\Security\CurrentUserRole;
use UserBundle\Model\UserBase;
use App\CurrentUser;

class User extends UserBase implements CurrentUserRole
{
    public function dataLabel()
    {
        return $this->account;
    }

    public function beforeCreate($args)
    {
        return $args;
    }

    public function beforeDelete()
    {
        // if we have multi-roles, delete these associative records.
        if (isset($this->roles)) {
            foreach ($this->getRoles() as $r) {
                $this->removeRole($r);
            }
        }
    }

    /**
     * For single role configuration compatibility
     * We provide this method to get roles from both `role` and `roles`
     */
    public function getRoles()
    {
        if (isset($this->roles)) {
            if ($roles = $this->roles->items()) {
                return array_map(function ($role) {
                    return $role->identity;
                }, $roles);
            }
        } elseif (isset($this->role)) {
            $role = $this->role;
            if (is_object($role)) {
                return array($role->identity);
            }
            return array($role);
        }
        return array();
    }

    public function addRole($roleId)
    {
        if ($this->hasRole($roleId)) {
            return;
        }

        // If multi-roles are defined
        if (isset($this->roles)) {
            $role = Role::loadOrCreate([ 'identity' => $roleId ], 'identity');
            if (! $role->id) {
                throw new Exception("Can't create or load Role record. '$roleId'");
            }

            $record = UserRole::loadOrCreate(
                [
                    'role_id' => $role->id,
                    'user_id' => $this->id
                ],
                ['role_id','user_id']
            );
            if (! $record) {
                throw new Exception("Can't create or load UserRole record");
            }

            return $role;
        } elseif (isset($this->role)) {
            $this->update([ 'role' => $roleId ]);
        }
    }


    /**
     * Remove a role from this user.
     *
     * This method is only available when the feature switch 'MultiRole' or
     * 'CustomRole' is enabled.
     *
     * @param string $roleId role identity, can be 'admin', 'guest' or 'staff'
     */
    public function removeRole($roleId)
    {
        if (!$this->hasRole($roleId)) {
            return;
        }
        $role = Role::load([ 'identity' => $roleId ]);
        if (!$role) {
            return;
        }

        $userRole = UserRole::load([ 'role_id' => $role->id , 'user_id' => $this->id ]);
        if ($userRole) {
            $userRole->delete();
        }
    }


    /**
     * Check if an user have a specific role.
     *
     * @return boolean
     */
    public function hasRole($roleId)
    {
        if (is_object($roleId)) {
            $roleId = $roleId->identity;
            $roles = $this->getRoles();
            return in_array($roleId, $roles);
        }
        if (isset($this->roles)) {
            $roles = $this->getRoles();
            return in_array($roleId, $roles);
        } elseif (isset($this->role)) {
            return $this->role == $roleId;
        }
    }

    /**
     * This method is used in AdminEmail, which returns an array structure that
     * can be used for SwiftMailer ->setTo, ->setCc, ->setBcc methods
     *
     * @return array
     */
    public function asMailEntry()
    {
        if ($this->name && $this->email) {
            return array( $this->email => $this->name );
        } elseif ($this->email) {
            return array( $this->email );
        }
        return array();
    }


    public function encryptPassword($plainPassword)
    {
        return sha1($plainPassword);
    }

    public function setPassword($plainPassword)
    {
        $this->password = $this->encryptPassword($plainPassword);
    }

    public function matchPassword($plainPassword)
    {
        return $this->password === $this->encryptPassword($plainPassword);
    }

    public function verifyOwnership(CurrentUser $currentUser)
    {
        if ($currentUser->isAdmin()) {
            return true;
        }

        return $this->id == $currentUser->id;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
