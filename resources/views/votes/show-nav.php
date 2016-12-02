<div class="vote-nav">
  <ul class="nav tab-underline tab-underline-sm border-bottom">
    <li class="<?= $req['sort'] == 'createTime' ? 'active border-primary' : '' ?>">
      <a class="text-active-primary" href="<?= $url->full('votes/%s/show', $vote['id'], ['sort' => 'createTime']) ?>">
        最新参赛
      </a>
    </li>
    <li class="<?= $req['sort'] == 'voteCount' ? 'active border-primary' : '' ?>">
      <a class="text-active-primary" href="<?= $url->full('votes/%s/show', $vote['id'], ['sort' => 'voteCount']) ?>">
        最新排名
      </a>
    </li>
  </ul>
</div>
