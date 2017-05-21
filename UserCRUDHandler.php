<?php
namespace UserBundle;
use Phifty\Bundle;
use Phifty\Region;
use AdminUI\CRUDHandler;
use UserBundle\Model\RoleCollection;

class UserCRUDHandler extends \AdminUI\CRUDHandler
{
    /* CRUD Attributes */
    public $modelClass = 'UserBundle\\Model\\User';
    public $crudId     = 'user';
    public $listColumns = array('id','email','role');

    public function editRegionActionPrepare()
    {
        parent::editRegionActionPrepare();
        $record = $this->getCurrentRecord();
        if ( $record->id ) {
            $this->assign('changePasswordAction', new Action\ChangePassword( $_REQUEST , $record ));
            $this->assign('setNewPasswordAction', new Action\SetNewPassword( $_REQUEST , $record ));
        }

        if( $this->bundle->config('with_multi_role') ) {
            $roles = new RoleCollection;
            $this->assign('roles', $roles);
        }
    }
    
}
