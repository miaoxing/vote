<?php

namespace Miaoxing\Vote\Service;

class VoteWork extends \miaoxing\plugin\BaseModel
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'voteWorks';

    /**
     * {@inheritdoc}
     */
    protected $providers = [
        'db' => 'app.db'
    ];

    protected $user;

    public function afterFind()
    {
        parent::afterFind();
        $this['images'] = (array)json_decode($this['images'], true);
    }

    public function beforeSave()
    {
        parent::beforeSave();
        $this['images'] = json_encode($this['images'], JSON_UNESCAPED_UNICODE);
    }

    public function getUser()
    {
        $this->user || $this->user = wei()->user()->findById($this['createUser']);
        return $this->user;
    }
}
