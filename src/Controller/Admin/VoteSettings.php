<?php

namespace Miaoxing\Vote\Controller\Admin;

class VoteSettings extends \Miaoxing\Plugin\BaseController
{
    protected $controllerName = '投票设置';

    protected $actionPermissions = [
        'index,update' => '设置',
    ];

    public function indexAction()
    {
        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $this->setting->setValues((array) $req['settings'], 'vote.');

        return $this->suc();
    }
}
