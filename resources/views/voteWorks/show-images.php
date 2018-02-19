<?php

$view->display('@app/app/swipe.php', ['images' => $voteWork['images']]);
?>

<?= $block->js() ?>
<script>
  require(['plugins/wechat/js/wx'], function (wx) {
    wx.load(function () {
      $('.js-images-preview img').click(function () {
        var urls = $(this).closest('.js-images-preview').find('img').map(function () {
          return this.src;
        }).get();
        wx.previewImage({
          current: $(this).attr('src'),
          urls: urls
        });
      });
    });
  });
</script>
<?= $block->end() ?>
