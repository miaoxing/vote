<div class="vote-body border-bottom">
  <div class="vote-time text-muted">
    开始时间：<?= date('Y-m-d', strtotime($vote['startTime'])) ?></br>
    结束时间：<?= date('Y-m-d', strtotime($vote['endTime'])) ?>
  </div>

  <div class="vote-description text-muted">参赛作品：<span class="js-attend-user-count"><?= count($voteWorks); ?></span></div>

  <div class="vote-description text-muted">
    活动说明：<?= $vote['description'] ?>
  </div>

  <span class="vote-tips left border-right text-muted">投票人数：<span class="js-attend-user-count"><?= $vote->getVoteUserCount(); ?></span></span>
  <span class="vote-tips right text-muted">投票次数：<span class="js-all-vote-count"><?= $vote->getAllVoteCount(); ?></span></span>

  <span class="vote-join pull-right">
    <?php if ($setting('vote.isOpen')) : ?>
      <?php if (!$curVoteWork) : ?>
      <a href="<?= $url->full('vote-works/new', ['voteId' => $vote['id']]) ?>"><button class="btn btn-success">我要报名</button></a>
      <?php else : ?>
      <a href="<?= $url->full('vote-works/%s/show', ['id' => $curVoteWork['id']]) ?>"><button class="btn btn-success">我的作品</button></a>
      <?php endif; ?>
    <?php endif; ?>
  </span>
</div>

