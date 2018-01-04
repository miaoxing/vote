<?php

namespace Miaoxing\Vote\Controller\admin;

class Votes extends \Miaoxing\Plugin\BaseController
{
    protected $controllerName = '投票管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update,updateDefault' => '编辑',
        'destroy' => '删除',
    ];

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $votes = wei()->vote()->curApp()->notDeleted();

                // 分页
                $votes->limit($req['rows'])->page($req['page']);

                // 排序
                $votes->desc('id');

                $data = [];
                foreach ($votes->findAll() as $vote) {
                    $data[] = $vote->toArray() + [
                            'userCount' => $vote->getAllVoteUserCount(),
                        ];
                }

                return $this->suc([
                    'message' => '读取列表成功',
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $votes->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $vote = wei()->vote()->curApp()->notDeleted()->findId($req['id']);

        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function updateAction($req)
    {
        $validator = wei()->validate([
            'data' => $req,
            'rules' => [
                'startTime' => [],
                'endTime' => [],
                'name' => [],
                'chanceRule' => [],
                'chances' => [],
                'description' => [
                    'required' => false,
                ],
            ],
            'names' => [
                'startTime' => '开始时间',
                'endTime' => '结束时间',
                'name' => '投票活动标题',
                'chanceRule' => '投票限制',
                'chances' => '投票次数',
                'description' => '投票活动详情',
            ],
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
        }

        $vote = wei()->vote()->curApp()->findId($req['id']);
        $vote->save($req);

        return $this->suc();
    }

    public function updateDefaultAction($req)
    {
        $vote = wei()->vote()->curApp()->notDeleted()->findOneById($req['id']);
        wei()->vote()->curApp()->andWhere('isDefault = 1')->update('isDefault = 0');
        $vote->save(['isDefault' => 1]);

        return $this->suc();
    }

    public function destroyAction($req)
    {
        $vote = wei()->vote()->curApp()->notDeleted()->findOneById($req['id']);
        $vote->softDelete();

        return $this->suc();
    }
}
