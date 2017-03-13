<?php

namespace Miaoxing\Vote\Service;

class VoteLog extends \miaoxing\plugin\BaseModel
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'voteLogs';

    /**
     * {@inheritdoc}
     */
    protected $providers = [
        'db' => 'app.db',
    ];

    /**
     * 记下日志
     * @param Vote $vote
     * @param VoteWork $voteWork
     * @param array $ret
     */
    public function log(Vote $vote, VoteWork $voteWork, array $ret)
    {
        wei()->voteLog()->setAppId()->save([
            'voteId' => $vote['id'],
            'voteWorkId' => $voteWork['id'],
            'userId' => wei()->curUser['id'],
            'message' => $ret['message'],
            'code' => $ret['code'],
            'ip' => wei()->request->getIp(),
        ]);
    }

    public function getVoteLogCountByTimeRange(Vote $vote, $startTime = '', $endTime = '')
    {
        $voteLogs = wei()->voteLog()
            ->curApp()
            ->andWhere(['code' => 1, 'voteId' => $vote['id'], 'userId' => wei()->curUser['id']]);

        if ($startTime && $endTime) {
            $voteLogs->andWhere('createTime between ? and ?', [$startTime, $endTime]);
        }

        $logCount = $voteLogs->count();

        return $logCount;
    }

    public function getVoteWorkLogCountByTimeRange(Vote $vote, VoteWork $voteWork, $startTime = '', $endTime = '')
    {
        $voteLogs = wei()->voteLog()
            ->curApp()
            ->andWhere([
                'code' => 1,
                'voteId' => $vote['id'],
                'userId' => wei()->curUser['id'],
                'voteWorkId' => $voteWork['id'],
            ]);

        if ($startTime && $endTime) {
            $voteLogs->andWhere('createTime between ? and ?', [$startTime, $endTime]);
        }

        $count = $voteLogs->count();

        return $count;
    }
}
