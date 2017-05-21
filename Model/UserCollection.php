<?php
namespace UserBundle\Model;

class UserCollection 
extends \UserBundle\Model\UserCollectionBase
{

    static public function findByRole($role) {
        $collection = new self;
        $users = new self;
        foreach( $collection as $item ) {
            if ( $item->hasRole($role) ) {
                $users->add($item);
            }
        }
        return $users;
    }

    static public function findAdmin() {
        return self::findByRole('admin');
    }

    static public function findUser() {
        return self::findByRole('user');
    }

    static public function findStaff() {
        return self::findByRole('staff');
    }

    /**
     * Return mail recipients for Swift mailer. setTo, setCc, setBcc methods.
     *
     * @return array
     */
    public function asMailEntries() {
        $recipients = array();
        foreach( $this as $item ) {
            if ( $item->name && $item->email ) {
                $recipients[ $item->email ] = $item->name;
            } elseif ( $item->email ) {
                $recipients[] = $item->email;
            }
        }
        return $recipients;
    }
}
