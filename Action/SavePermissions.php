<?php
namespace UserBundle\Action;

use ActionKit\Action;
use Kendo\Model\AccessControlCollection;
use Kendo\Model\AccessControl;
use Exception;

class SavePermissions extends Action
{
    public function schema()
    {
        $this->param('controls');
    }


    public function run()
    {
        if ($controls = $this->request->param('controls')) {
            foreach ($controls as $controlId => $allow) {
                $control = new AccessControl($controlId);
                $ret = $control->update(array('allow' => $allow == '1' ? true : false));
                if (! $ret->success) {
                    return $this->error($ret->message);
                }
            }
            return $this->success("權限設定完成");
        }
        return $this->error("Can not save permission preferences");
    }
}
