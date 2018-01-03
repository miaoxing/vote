<?php

namespace Miaoxing\Vote\Controller;

use Miaoxing\Plugin\Middleware\RateLimit;

class VoteWorks extends \miaoxing\plugin\BaseController
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->middleware(RateLimit::class, [
            'only' => 'vote',
            'timeWindow' => RateLimit::MINUTE,
            'max' => 100,
        ]);
    }

    public function showAction($req)
    {
        if (!$req['id']) {
            return $this->err('缺少参数');
        }

        $voteWork = wei()->voteWork()->curApp()->findById($req['id']);
        $maxCount = wei()->voteWork()
            ->select('max(voteCount) as maxCount')
            ->curApp()
            ->andWhere(['voteId' => $voteWork['voteId']])
            ->andWhere('deleteTime = ?', ['0000-00-00 00:00:00'])
            ->fetch()['maxCount'];

        // 增加排名和与上一名相差的票数
        $sql = 'select * from (select A.*,@rank:=@rank+1 as rank, @lastCount-@lastCount:=A.voteCount as lastCount FROM';
        $sql .= ' (select * from app.voteWorks where deleteTime="0000-00-00 00:00:00" and appId=';
        $sql .= wei()->app->getId() . ' and voteId=' . $voteWork['voteId'];
        $sql .= ' order by voteCount desc) A ,(select @rank:=0, @lastCount:=' . $maxCount . ') B) M ';
        $sql .= 'where appId=' . wei()->app->getId() . ' and M.id=' . $req['id'];

        $voteWork = wei()->db->query($sql)->fetchAll()[0];
        $voteWork['images'] = json_decode($voteWork['images'], true);

        $vote = wei()->vote()->curApp()->findOneById($voteWork['voteId']);

        $headerTitle = $voteWork['name'];

        return get_defined_vars();
    }

    public function voteAction($req)
    {
        $voteWork = wei()->voteWork()->curApp()->findOneById($req['voteWorkId']);
        $vote = wei()->vote()->curApp()->findOneById($voteWork['voteId']);
        $ret = $vote->vote($voteWork);

        return $this->ret($ret);
    }

    public function newAction($req)
    {
        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $validator = wei()->validate([
            'data' => $req,
            'rules' => [
                'username' => [],
                'mobile' => [
                    'mobileCn' => true,
                ],
                'name' => [],
                'images' => [],
                'voteId' => [],
            ],
            'names' => [
                'username' => '姓名',
                'mobile' => '电话',
                'name' => '作品名称',
                'images' => '作品图片',
                'voteId' => '活动ID',
            ],
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
        }

        if (!wei()->curUser['isValid']) {
            return $this->err('请先关注公众号，再报名参赛');
        }

        $voteWork = wei()->voteWork()->curApp()->findId($req['id']);
        $voteWork->save($req);

        return $this->suc();
    }
}
