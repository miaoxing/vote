<?php

namespace Miaoxing\Vote\Controller\Admin;

class VoteUsers extends \Miaoxing\Plugin\BaseController
{
    protected $controllerName = '投票用户管理';

    protected $actionPermissions = [
        'index' => '列表',
    ];

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $search = [];
                if ($req['voteId']) {
                    $search += ['voteId' => $req['voteId']];
                }

                if ($req['voteWorkId']) {
                    $search += ['voteWorkId' => $req['voteWorkId']];
                }

                $voteUsers = wei()->voteUser()->curApp()->andWhere($search);

                // 分页
                $voteUsers->limit($req['rows'])->page($req['page']);

                // 排序
                $voteUsers->desc('id');

                $data = [];
                foreach ($voteUsers->findAll() as $voteUser) {
                    $data[] = $voteUser->toArray() + [
                            'user' => $voteUser->getUser()->toArray(),
                            'voteWork' => $voteUser->getVoteWork()->toArray(),
                        ];
                }

                return $this->suc([
                    'message' => '读取列表成功',
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $voteUsers->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }
}
