<?php

namespace Miaoxing\Vote;

class Plugin extends \miaoxing\plugin\BasePlugin
{
    protected $name = '投票活动';

    protected $adminNavId = 'marketing';

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $subCategories['setting'] = [
            'parentId' => 'marketing',
            'name' => '设置',
            'icon' => 'fa fa-gear',
            'sort' => 0,
        ];

        $navs[] = [
            'parentId' => 'marketing-activities',
            'url' => 'admin/votes',
            'name' => '投票管理',
        ];

        $navs[] = [
            'parentId' => 'setting',
            'url' => 'admin/vote-settings',
            'name' => '投票功能设置',
            'sort' => 0,
        ];
    }

    public function onLinkToGetLinks(&$links, &$types)
    {
        $links[] = [
            'typeId' => 'marketing',
            'url' => 'votes/default',
            'name' => '默认投票活动',
        ];
    }
}
