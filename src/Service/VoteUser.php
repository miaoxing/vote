<?php

namespace Miaoxing\Vote\Service;

use Miaoxing\Plugin\Service\User;

class VoteUser extends \miaoxing\plugin\BaseModel
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'voteUsers';

    /**
     * {@inheritdoc}
     */
    protected $providers = [
        'db' => 'app.db',
    ];

    /**
     * @var User
     */
    protected $user;

    /**
     * @var VoteWork
     */
    protected $voteWork;

    public function getUser()
    {
        $this->user || $this->user = wei()->user()->findOrInitById($this['userId']);

        return $this->user;
    }

    public function getVoteWork()
    {
        $this->voteWork || $this->voteWork = wei()->voteWork()->findOrInitById($this['voteWorkId']);

        return $this->voteWork;
    }
}
