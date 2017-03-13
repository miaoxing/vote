<div class="vote-work-section border-bottom">
  <span class="title text-left"><?= $voteWork['name'] ?></span>
</div>

<div class="vote-work-section border-bottom">
  <span class="content text-left">
    票数：<span class="text-primary js-vote-count"><?= $voteWork['voteCount'] ?></span>
  </span>

  <span class="content text-right">
    距离第一名还差：<span class="text-primary js-last-count"><?= $maxCount - $voteWork['voteCount'] ?></span>票
  </span>
</div>

<div class="vote-work-section border-bottom">
  <span class="content text-left">
    排名：<span class="text-primary js-rank"><?= $voteWork['rank'] ?></span>
  </span>
</div>

<div class="vote-work-body border-bottom">
  <div class="description text-muted">
    简介：<?= $voteWork['description'] ?>
  </div>

  <span class="vote-tips left border-right text-muted">已投票人数：<span class="js-vote-work-user-count"><?= $voteWork['voteUserCount'] ?></span></span>
  <span class="vote-tips right text-muted"><?= date('Y 年 m 月 d 日', strtotime($vote['endTime'])) ?> 截止</span>
</div>
