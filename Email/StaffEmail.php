<?php
namespace UserBundle\Email;
use EmailBundle\BaseEmail;
use UserBundle\Model\UserCollection;

/**
 * StaffEmail send email to all admin.
 *
 * $email = new StaffEmail;
 * $email->send();
 */
abstract class StaffEmail extends BaseEmail
{
    public $format = 'text/html';

    public function from() {
         return kernel()->getSystemMail();
    }

    public function to() {
        $recipients = UserCollection::findStaff();
        $recipients->where()->equal('receive_email', true);
        return $recipients->asMailEntries();
    }

    public function getLang() {
        return kernel()->locale->current();
    }

    public function subject() {
         return kernel()->getApplicationName() . ' - ' . $this->getTitle();
    }
}

