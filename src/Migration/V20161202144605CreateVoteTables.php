<?php

namespace Miaoxing\Vote\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20161202144605CreateVoteTables extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('votes')
            ->id()
            ->int('appId')
            ->string('name', 64)->comment('活动名称')
            ->string('description')
            ->timestamp('startTime')
            ->timestamp('endTime')
            ->text('styles')
            ->text('rule')
            ->bool('isDefault')
            ->bool('isRepeated')->defaults(1)->comment('是否可重复投票的')
            ->string('chanceRule', 16)
            ->int('chances', 4)
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();

        $this->schema->table('voteWorks')
            ->id()
            ->int('appId')
            ->int('voteId')
            ->string('name', 64)
            ->mediumText('description')
            ->string('username', 16)
            ->string('mobile', 16)
            ->int('voteCount', 4)
            ->int('voteUserCount', 4)
            ->mediumText('images')
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();

        $this->schema->table('voteUsers')
            ->id()
            ->int('appId')
            ->int('voteId')
            ->int('voteWorkId')
            ->int('userId')
            ->int('voteCount', 4)
            ->timestamps()
            ->exec();

        $this->schema->table('voteLogs')
            ->id()
            ->int('appId')
            ->int('voteId')
            ->int('voteWorkId')
            ->int('userId')
            ->int('code', 1)->comment('是否成功，1表示成功')
            ->string('message', 32)
            ->string('ip', 16)
            ->timestamp('createTime')
            ->index('voteId')
            ->index('code')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('votes');
        $this->schema->dropIfExists('voteWorks');
        $this->schema->dropIfExists('voteUsers');
        $this->schema->dropIfExists('voteLogs');
    }
}
