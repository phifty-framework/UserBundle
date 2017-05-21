<?php
namespace UserBundle\Email;
use EmailBundle\BaseEmail;
use MemberBundle\CurrentMember;
use UserBundle\Model\UserCollection;
use UserBundle\Model\User;

/**
 * UserEmail: send email to an user.
 *
 *    $email = new UserEmail; // send to all users
 *    $email = new UserEmail( $user ); // send to one user
 *    $email = new UserEmail( $users ); // send to many users (UserCollection)
 *
 *    $email->setBody( ... ); // use message interface directly
 *    $email->setSubject('...'); // use message interface directly
 *
 *    $email->send(); // finally, send the email
 */
class UserEmail extends BaseEmail
{
    public $format = 'text/html';

    /**
     * @var string template handle
     */
    public $templateHandle = 'user';

    /**
     * @var $users User collection
     */
    public $users;

    public function __construct($arg = null) {
        if ( $arg instanceof User) {
            // create an empty user collection and add the User record object into it.
            $this->users = new UserCollection;
            $this->users->add($arg);
        } else if ( $arg instanceof UserCollection ) {
            $this->users = new UserCollection;
        } else {
            $this->users = new UserCollection;
        }
    }

    public function from() {
         return kernel()->getSystemMail();
    }

    public function to() {
        return $this->users->asMailEntries();
    }
}

