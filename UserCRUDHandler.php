<?php

namespace UserBundle;

use Phifty\Bundle;
use Phifty\Region;
use AdminUI\CRUDHandler;
use UserBundle\Model\RoleCollection;
use UserBundle\Model\User;

class UserCRUDHandler extends \AdminUI\CRUDHandler
{
    public $modelClass = User::class;

    public $crudId     = 'user';

    public $resourceId = 'user';

    public $listColumns = array('id','email','role');

    public $quicksearchFields = [ 'email', 'account' ];

    public function editRegionActionPrepare()
    {
        parent::editRegionActionPrepare();
        $record = $this->getCurrentRecord();
        if ($record->hasKey()) {
            $this->assign('changePasswordAction', new Action\ChangePassword( $_REQUEST , $record ));
            $this->assign('setNewPasswordAction', new Action\SetNewPassword( $_REQUEST , $record ));
        }

        if( $this->bundle->config('with_multi_role') ) {
            $roles = new RoleCollection;
            $this->assign('roles', $roles);
        }
    }
}
