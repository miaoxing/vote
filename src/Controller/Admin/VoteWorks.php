<?php

namespace Miaoxing\Vote\Controller\admin;

class VoteWorks extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '投票作品管理';

    protected $actionPermissions = [
        'index' => '列表',
    ];

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json' :
                $voteWorks = wei()->voteWork()->curApp()->andWhere(['voteId' => $req['voteId']])->notDeleted();

                // 分页
                $voteWorks->limit($req['rows'])->page($req['page']);

                // 排序
                if ($req["order"] && $req["sort"]) {
                    $req["order"] == "asc" ? $voteWorks->asc($req["sort"]) : $voteWorks->desc($req["sort"]);
                } else {
                    $voteWorks->desc('id');
                }

                if ($req["name"]) {
                    $voteWorks->andWhere('name like ?', '%'. $req["name"] .'%');
                }

                $data = [];
                foreach ($voteWorks as $voteWork) {
                    $data[] = $voteWork->toArray() + [
                            'user' => $voteWork->getUser()
                        ];
                }

                return $this->suc([
                    'message' => '读取列表成功',
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $voteWorks->count(),
                ]);

            default :
                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $voteWork = wei()->voteWork()->curApp()->notDeleted()->findId($req['id']);
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
                'name' => [],
                'voteId' => [],
            ],
            'names' => [
                'name' => '作品名称',
                'voteId' => '活动ID'
            ]
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
        }

        $voteWork = wei()->voteWork()->curApp()->findId($req['id']);
        $voteWork->save($req);

        return $this->suc();
    }

    public function destroyAction($req)
    {
        $voteWork = wei()->voteWork()->curApp()->notDeleted()->findOneById($req['id']);
        $voteWork->softDelete();
        return $this->suc();
    }
}
