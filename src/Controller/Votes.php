<?php

namespace Miaoxing\Vote\Controller;

class Votes extends \miaoxing\plugin\BaseController
{
    public function showAction($req)
    {
        $vote = wei()->vote()->curApp()->notDeleted()->findOneById($req['id']);

        $voteWorks = wei()->voteWork()->curApp()->notDeleted()->andWhere(['voteId' => $vote['id']]);

        if ($req['search']) {
            $voteWorks->andWhere('name like ?', '%' . $req['search'] . '%');
        }

        $req['sort'] = $req['sort'] ?: 'createTime';
        $voteWorks->desc($req['sort']);

        $data = [];
        $curVoteWork = null;
        foreach ($voteWorks->findAll() as $voteWork) {
            $data[] = $voteWork->toArray();

            // 当前用户是否有参数作品
            if (!$curVoteWork && $voteWork['createUser'] == wei()->curUser['id']) {
                $curVoteWork = $voteWork;
            }
        }
        $voteWorks = $data;

        $headerTitle = $vote['name'];

        return get_defined_vars();
    }

    /**
     * 获取默认投票活动,并跳转到活动页面
     */
    public function defaultAction($req)
    {
        $default = wei()->vote()->curApp()->find(['isDefault' => 1]);
        if (!$default) {
            return $this->err('暂无默认投票活动');
        }

        $req['id'] = $default['id'];
        $this->app->forward('votes', 'show');
    }
}
