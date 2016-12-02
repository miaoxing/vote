<div class="js-vote-slider swipe">
  <div class="js-images-preview swipe-wrap">
    <?php foreach ($voteWork['images'] as $index => $image) : ?>
      <div>
        <img src="<?= $image ?>"/>
      </div>
    <?php endforeach ?>
  </div>
  <ol class="swipe-nav">
    <?php foreach ($voteWork['images'] as $index => $image) : ?>
      <li><a class="<?= $index == 0 ? 'swipe-nav-active' : '' ?>"></a></li>
    <?php endforeach ?>
  </ol>
</div>

<?= $block('js') ?>
<script>
  $('.js-vote-slider').Swipe({
    auto: 3000,
    callback: function (index, elem) {
      var nav = $(elem).parent().next().find('a');
      nav.removeClass('swipe-nav-active').eq(index).addClass('swipe-nav-active');
    }
  }).fixSwipeImgHeight();

  require(['plugins/wechat/assets/wx'], function (wx) {
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
