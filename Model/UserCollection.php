<?php
namespace UserBundle\Model;

class UserCollection extends \UserBundle\Model\UserCollectionBase
{
    public static function findByRole($role)
    {
        $collection = new self;
        $users = new self;
        foreach ($collection as $item) {
            if ($item->hasRole($role)) {
                $users->add($item);
            }
        }
        return $users;
    }

    public static function findAdmin()
    {
        return self::findByRole('admin');
    }

    public static function findUser()
    {
        return self::findByRole('user');
    }

    public static function findStaff()
    {
        return self::findByRole('staff');
    }

    /**
     * Return mail recipients for Swift mailer. setTo, setCc, setBcc methods.
     *
     * @return array
     */
    public function asMailEntries()
    {
        $recipients = array();
        foreach ($this as $item) {
            if ($item->name && $item->email) {
                $recipients[ $item->email ] = $item->name;
            } elseif ($item->email) {
                $recipients[] = $item->email;
            }
        }
        return $recipients;
    }
}
