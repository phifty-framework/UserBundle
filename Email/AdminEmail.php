<?php
namespace UserBundle\Email;
use EmailBundle\BaseEmail;
use UserBundle\Model\UserCollection;

/**
 * AdminEmail send email to all admin.
 *
 * $email = new AdminEmail;
 * $email->send();
 */
abstract class AdminEmail extends BaseEmail
{
    public $format = 'text/html';

    public function from() {
         return kernel()->getSystemMail();
    }

    public function to() {
        $recipients = UserCollection::findAdmin();
        $recipients->where()->equal('receive_email', true);
        return $recipients->asMailEntries();
    }

    public function getLang() {
        return kernel()->locale->current();
    }
}

