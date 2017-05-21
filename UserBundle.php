<?php
namespace UserBundle;
use Phifty\Bundle;
use Phifty\Region;
use AdminUI\CRUDHandler;


/**
Config
-----------

For account confirmation:

    User:
      confirmation:
        url: '/bs/user/confirm'
        by: 'admin' | 'user'
        email:
          admin_confirm:
            from: ...
            to: {admin email}
            subject:
            template:
              user:
              admin:
          user_confirm:
            from: ...
            subject:
            template:
              user:
              admin:
 
When 'by' is set to 'user', we send user confirmation email to the user, let the user clicks 
the confirmation URL to confirm the account.

  'template.user' is the confirmation email template.
  'template.admin' is the notification email template.

When 'by' is set to 'admin', we send user register notification email to the 
user, and user confirmation email to admin to let admin approve the registration.

  'template.user' is the notification email template.
  'template.admin' is the confirmation email template.

To support I18N email template, you may specify "{{lang}}" in the path to use the correspond
email template.

 */

class UserBundle extends Bundle 
{


    public function defaultConfig() {
        return array(
            'UseAccount' => true,

            // Disable by default.
            'MultiRole' => false,
            'CustomRole' => false,
            'Management' => false && array( 'User' => false, 'Role' => false ),
        );
    }

    /* init method */
    public function init()
    {
        // this is overrided by AdminUI routes
        $this->route( '/bs/logout' , 'LogoutController' ); // refers to \User\Controller\Logout
        $this->route( '/bs/logged_out' , 'LogoutPage' );

        if ( $this->config('allow_register') ) {
            $this->route( '/bs/user/register' , 'RegisterController' );
        }

        $this->route( '/bs/user/confirm' , 'ConfirmController' );

        if (! $this->config('Management')) {
            return;
        }

        $this->addRecordAction('Role',array('Create','Update','Delete'));
        $this->mount('/bs/user', 'UserCRUDHandler' );
        $this->mount('/bs/role', 'RoleCRUDHandler' );

        $self = $this;
        $this->kernel->event->register( 'adminui.init_menu' , function($menu) use ($self) {
            $kernel = kernel();
            $currentUser = $kernel->currentUser;

            $folder = null;

            if ( $self->config('Management.User') != false ) {
                if ( isset($kernel->acl) && $kernel->acl->can( $currentUser, 'user', 'view' ) ) {
                    if ( ! $folder ) {
                        if ( $label = $self->config('label') ) {
                            $folder = $menu->createMenuFolder( _($label) , 0 );
                        } else {
                            $folder = $menu->createMenuFolder( _('User Management') , 0 );
                        }
                    }
                    $folder->createCrudMenuItem('user','使用者管理');
                }
            }

            if ( $self->config('Management.Role') != false ) {
                if( isset($kernel->acl) && $kernel->acl->can( $currentUser, 'user_roles', 'view' ) ) {
                    if ( ! $folder ) {
                        $folder = $menu->createMenuFolder( _('User Management') , 0 );
                    }
                    $folder->createCrudMenuItem( 'role', '角色管理');
                }
            }
        });
    }
}
