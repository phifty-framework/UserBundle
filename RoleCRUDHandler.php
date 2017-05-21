<?php
namespace UserBundle;
use Phifty\Bundle;
use Phifty\Region;
use AdminUI\CRUDHandler;

use Kendo\Model\AccessControlCollection;
use Kendo\Model\AccessResourceCollection;
use Kendo\Model\AccessRuleCollection;

class RoleCRUDHandler extends \AdminUI\CRUDHandler
{
    public $modelClass = 'UserBundle\Model\Role';
    public $crudId = 'role';

    function editRegionActionPrepare()
    {
        parent::editRegionActionPrepare();
        if( kernel()->acl->can(kernel()->currentUser, 'user_roles','edit_permissions',false) ) {
#              $controls = new AccessControlCollection;
#              $controls->where()
#                  ->equal('role', $this->currentRecord->identity);
#              $controls->order('rule_id','desc');
        }
        $resources = new AccessResourceCollection;
        $this->assign('accessResources',$resources);
    }
}
