<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/vote/css/vote.css') ?>"/>
<?= $block->end() ?>

<?php require $view->getFile('vote:votes/show-image.php') ?>
<?php require $view->getFile('vote:votes/show-header.php') ?>
<?php require $view->getFile('vote:votes/show-body.php') ?>
<?php require $view->getFile('vote:votes/show-nav.php') ?>
<?php require $view->getFile('vote:votes/show-list.php') ?>

<?= $block->js() ?>
<script>
  var vote = <?= $vote->toJson(); ?>;
  $('.js-btn-rule').click(function () {
    $.alert(vote.rule);
  });

  // 刷新页面之前记录滚动条位置
  var saveScroll = function () {
    var scrollPos;
    if (typeof window.pageYOffset != 'undefined') {
      scrollPos = window.pageYOffset;
    }
    else if (typeof document.compatMode != 'undefined' &&
      document.compatMode != 'BackCompat') {
      scrollPos = document.documentElement.scrollTop;
    }
    else if (typeof document.body != 'undefined') {
      scrollPos = document.body.scrollTop;
    }
    document.cookie = "scrollTop=" + scrollPos; //存储滚动条位置到cookies中
  };

  window.onunload = saveScroll;

  window.onload = function () {
    if (document.cookie.match(/scrollTop=([^;]+)(;|$)/) != null) {
      var arr = document.cookie.match(/scrollTop=([^;]+)(;|$)/); //cookies中不为空，则读取滚动条位置
      document.documentElement.scrollTop = parseInt(arr[1]);
      document.body.scrollTop = parseInt(arr[1]);
    }
  }
</script>
<?= $block->end(); ?>

