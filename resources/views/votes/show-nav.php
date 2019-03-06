<div class="vote-nav">
  <ul class="header-nav nav nav-underline">
    <li class="nav-item">
      <a class="nav-link text-active-primary border-active-primary <?= $req['sort'] == 'createTime' ? 'active border-primary' : '' ?>" href="<?= $url->full('votes/%s/show', $vote['id'], ['sort' => 'createTime']) ?>">
        最新参赛
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-active-primary border-active-primary <?= $req['sort'] == 'voteCount' ? 'active border-primary' : '' ?>" href="<?= $url->full('votes/%s/show', $vote['id'], ['sort' => 'voteCount']) ?>">
        最新排名
      </a>
    </li>
  </ul>
</div>
