<?php
namespace UserBundle\Action;
use ActionKit\RecordAction\CreateRecordAction;
use Phifty\Message\Email;
use UserBundle\Message\AdminConfirmationEmail;

/**

    User:
      confirmation:
        cc:
        bcc:
        from:
        subject:
 */
class RegisterUser extends CreateRecordAction
{
    public $recordClass = 'UserBundle\\Model\\User';

    /**
     * @var string The default role identity
     */
    public $defaultRole = 'user';

    public function __construct( $args = array(), $record = null, $currentUser = null ) 
    {
        $cUser = kernel()->currentUser;
        $this->recordClass = $cUser->getModelClass();
        return parent::__construct( $args, $record, $currentUser );
    }

    public function schema() 
    {
        $this->useRecordSchema();
        $this->filterOut('role','password');

        $this->param('password1')
            ->renderAs('PasswordInput')
            ->label('密碼')
            ;
        $this->param('password2')
            ->renderAs('PasswordInput')
            ->label('密碼確認')
            ;
    }

    public function run()
    {
        $bundle = \UserBundle\UserBundle::getInstance();

        $from      = $this->arg('from');
        $account   = trim($this->arg('account'));
        $email     = trim($this->arg('email'));
        $password1 = $this->arg('password1');
        $password2 = $this->arg('password2');

        if ( ! $account && ! $email ) {
            return $this->error(_('Please enter email or account.'));
        }

        $user = new \UserBundle\Model\User;
        if ( $account ) {
            $user->load(array('account' => $account));
        } else if ( $email ) {
            $user->load(array('email' => $email));
        }

        if ( $user->id ) {
            return $this->error( _('Duplicated email or account.') );
        }

        if ( ! $password1 || ! $password2 ) {
            return $this->error( _('Please enter password.') );
        }

        if ( $password1 != $password2 ) {
            return $this->error( _('Password is not correct.') );
        }

        if ( strlen($password1) < 6 ) {
            return $this->error( _('Password should be more than 6 chars') );
        }

        $this->setArgument( 'password' , sha1( $password1 ) );
        // $this->setArgument( 'role' , $this->role );
        $this->setArgument( 'role' , $this->defaultRole );

        $ret = parent::run();
        if ( $ret ) {
            if ( $bundle->config('confirmation.by') == 'user' ) {
                die('not implemented yet');
                // $this->sendUserConfirmationEmail();
            } else if ( $bundle->config('confirmation.by') == 'admin' ) {
                $this->sendAdminConfirmationEmail();
            }
        }
        return $ret;
    }

    public function sendAdminConfirmationEmail()
    {
        $bundle = \UserBundle\UserBundle::getInstance();
        $email = new AdminConfirmationEmail($this->record);
        if ( $template = $bundle->config('confirmation.email.admin_confirm.admin.template') ) {
            $email->setTemplate($template);
        }
        if ( $subject = $bundle->config('confirmation.email.admin_confirm.admin.subject') ) {
            $email->setSubject($subject);
        }
        if ( $from = $bundle->config('confirmation.email.admin_confirm.admin.from') ) {
            $email->setFrom( (array) $from );
        }
        if ( $to = $bundle->config('confirmation.email.admin_confirm.admin.to') ) {
            $email->setTo( (array) $to);
        }
        if ( $url = $bundle->config('confirmation.url') ) {
            $email['confirmation_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $url . '?token=' . $this->record->auth_token;
        } else {
            $email['confirmation_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/bs/user/confirm?token=' . $this->record->auth_token;
        }
        $email->send();
    }


    public function sendAdminNotificationEmail()
    {
        /*
        $user = $this->record;
        $bundle = \UserBundle\UserBundle::getInstance();
        $message = Swift_Message::newInstance();
        $message->setTo( (array) $user->email );
         */
    }


    public function sendUserConfirmationEmail()
    {
        $user = $this->record;
        $bundle = \UserBundle\UserBundle::getInstance();
        $message = Swift_Message::newInstance();
        $message->setTo( (array) $user->email );

        $emailConfig = $bundle->config('confirmation.email.user_confirm');

        if ( $subject = $emailConfig->config('subject') ) {
            $message->setSubject( _($subject) );
        } else {
            $message->setSubject( _('Registration Confirmation') );
        }

        if ( $from = $emailConfig->config('from')) {
            $message->setFrom(array($from));
        }
        if ( $cc = $emailConfig->config('cc') ) {
            $message->addCc((array)$cc);
        }

        if ( $bcc = $emailConfig->config('bcc') ) {
            $message->addBcc((array)$bcc);
        }

        if ( $replyTo = $emailConfig->config('reply_to') ) {
            $message->setReplyTo(array($replyTo));
        }

        $userTemplate = $emailConfig->config('user_template') ?:  '@UserBundle/email/user_confirm/user.html';
        $adminTemplate = $emailConfig->config('admin_template') ?: '@UserBundle/email/user_confirm/admin.html';

        $view = kernel()->view;
        $html = $view->render( '@UserBundle/email/zh_TW/registration.html' , array(
            'user'  => $user,
        ));
        $message->setBody($html,'text/html');
        kernel()->mailer->send($message);



        $view = kernel()->view;
        $html = $view->render( '@UserBundle/email/zh_TW/registration.html' , array(
            'user'  => $user,
        ));
        $message->setBody($html,'text/html');
        kernel()->mailer->send($message);
    }

    public function successMessage($ret)
    {
        return _("Your registration is successful"); //  , $this->record->getLabel() );
    }

}

