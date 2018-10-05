<?php

namespace Miaoxing\Vote\Service;

class Vote extends \Miaoxing\Plugin\BaseModel
{
    protected $table = 'votes';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $data = [
        'chances' => 3,
        'chanceRule' => 'all',
    ];

    protected $chanceRules = [
        'all' => '整个活动',
        'everyDay' => '每个自然日',
    ];

    public function getRulesToOptions()
    {
        $data = [];
        foreach ($this->chanceRules as $id => $value) {
            $data[] = [
                'id' => $id,
                'name' => $value,
            ];
        }

        return $data;
    }

    /**
     * 投票
     * @param VoteWork $voteWork
     * @return array
     */
    public function vote(VoteWork $voteWork)
    {
        //1. 检查是否可投票
        $ret = $this->checkVotable($voteWork);
        if ($ret['code'] < 0) {
            wei()->voteLog->log($this, $voteWork, $ret);

            return $ret;
        }

        //2. 当前用户是否投过该作品
        $voteUser = wei()->voteUser()
            ->curApp()
            ->findOrInit(['userId' => wei()->curUser['id'], 'voteWorkId' => $voteWork['id'], 'voteId' => $this['id']]);

        $extData = [];
        if ($voteUser->isNew()) {
            $voteWork->incr('voteUserCount');

            // 检查是否新增作品投票人数
            $extData = ['addVoteWorkUserCount' => 1];

            // 检查是否新增投票人数
            $count = wei()->voteUser()->curApp()
                ->andWhere(['voteId' => $this['id'], 'voteWorkId' => $voteWork['id']])
                ->findAll()
                ->count();

            if ($count == 0) {
                $extData = ['addVoteUserCount' => 1];
            }
        }

        $voteWork->incr('voteCount');
        $voteWork->save();

        $voteUser->incr('voteCount');
        $voteUser->save();

        $ret += $extData;
        $ret['message'] = '投票成功,您还可以投票' . ($ret['leftChances'] - 1) . '次';
        wei()->voteLog->log($this, $voteWork, $ret);

        return $ret;
    }

    /**
     * 检查是否可以投票
     * @param VoteWork $voteWork
     * @return array
     */
    public function checkVotable(VoteWork $voteWork)
    {
        if (!wei()->curUser['isValid']) {
            return ['code' => -5, 'message' => '未关注公众号不可参与投票'];
        }

        $now = date('Y-m-d H:i:s');

        if ($this['startTime'] > $now) {
            return ['code' => -4, 'message' => '活动未开始'];
        }

        if ($this['endTime'] < $now) {
            return ['code' => -3, 'message' => '活动已结束'];
        }

        if ($this->isSoftDeleted()) {
            return ['code' => -2, 'message' => '活动已下线'];
        }

        // 统计当前投票数量
        $logCount = 0;
        switch ($this['chanceRule']) {
            case 'all':
                if (!$this['isRepeated']) {
                    $count = wei()->voteLog->getVoteWorkLogCountByTimeRange($this, $voteWork);
                    if ($count >= 1) {
                        return ['code' => -6, 'message' => '不可重复投同一个作品'];
                    }
                }

                $logCount = wei()->voteLog->getVoteLogCountByTimeRange($this);
                break;

            case 'everyDay':
                $nextDay = date('Y-m-d', time() + 86400);
                if (!$this['isRepeated']) {
                    $count = wei()->voteLog->getVoteWorkLogCountByTimeRange($this, $voteWork, date('Y-m-d'), $nextDay);
                    if ($count >= 1) {
                        return ['code' => -6, 'message' => '同一天不能重复投同一个作品'];
                    }
                }

                $logCount = wei()->voteLog->getVoteLogCountByTimeRange($this, date('Y-m-d'), $nextDay);
                break;
        }

        $leftChances = $this['chances'] - $logCount;
        if ($leftChances <= 0) {
            return ['code' => -1, 'message' => '超过投票次数'];
        }

        return ['code' => 1, 'message' => '可以投票', 'leftChances' => $leftChances];
    }

    /**
     * 总人次
     * @return int
     */
    public function getAllVoteUserCount()
    {
        $data = wei()->voteWork()
            ->select('sum(voteUserCount) as count')
            ->curApp()
            ->andWhere(['voteId' => $this['id']])
            ->fetch();

        return $data['count'] ?: 0;
    }

    /**
     * 总投票数
     * @return int
     */
    public function getAllVoteCount()
    {
        $data = wei()->voteWork()
            ->select('sum(voteCount) as count')
            ->curApp()
            ->andWhere(['voteId' => $this['id']])
            ->fetch();

        return $data['count'] ?: 0;
    }

    /**
     * 参与人数
     * @return int
     */
    public function getVoteUserCount()
    {
        $data = wei()->voteUser()
            ->select('count(distinct(userId)) as count')
            ->curApp()
            ->andWhere(['voteId' => $this['id']])
            ->fetch();

        return $data['count'] ?: 0;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this['styles'] = (array) json_decode($this['styles'], true);
    }

    public function beforeSave()
    {
        parent::beforeSave();
        $this['styles'] = json_encode($this['styles'], JSON_UNESCAPED_UNICODE);
    }
}
