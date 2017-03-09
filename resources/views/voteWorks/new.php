<?php $view->layout() ?>

<form class="js-vote-form form" method="post">
  <div class="form-group">
    <label for="username" class="control-label">
      姓名
      <span class="text-warning">*</span>
    </label>

    <div class="col-control">
      <input type="text" class="form-control" id="username" name="username" placeholder="请输入姓名">
    </div>
  </div>

  <div class="form-group">
    <label for="mobile" class="control-label">
      电话号码
      <span class="text-warning">*</span>
    </label>

    <div class="col-control">
      <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="请输入电话">
    </div>
  </div>

  <div class="form-group">
    <label for="name" class="control-label">
      作品名称
      <span class="text-warning">*</span>
    </label>

    <div class="col-control">
      <input type="text" class="form-control" id="name" name="name" placeholder="请输入作品名称">
    </div>
  </div>

  <div class="form-group">
    <label for="description" class="control-label">
      作品详情
      <span class="text-warning">*</span>
    </label>

    <div class="col-control">
      <textarea class="form-control" id="description" name="description" rows="6"></textarea>
    </div>
  </div>

  <div class="form-group js-upload-container">
  </div>

  <input type="hidden" name="voteId" id="voteId" value="<?= $e($req['voteId']) ?>">

  <div class="form-footer">
    <button type="submit" class="btn btn-primary btn-block">提 交</button>
  </div>
</form>

<?php require $view->getFile('@wechat-image/wechat-image/uploadImage.php') ?>
<?php require $view->getFile('vote:voteWorks/new-append.php') ?>

<?= $block('js') ?>
<script>
  require(['jquery-form'], function () {
    $('.js-vote-form')
      .ajaxForm({
        url: $.url('vote-works/update'),
        type: 'post',
        loading: true,
        dataType: 'json',
        success: function (ret) {
          $.msg(ret, function () {
            if (ret.code === 1) {
              window.location.href = $.url('votes/%s/show', '<?= $e($req['voteId']) ?>');
            }
          });
        }
      });
  });

  // 图片上传
  require([
    'plugins/wechat-image/js/wechat-image',
    'plugins/wechat<?= ($isCrop = wei()->plugin->isInstalled('wechatCorp')) ? 'Corp' : '' ?>/js/wx<?= $isCrop ? '-corp' : '' ?>',
    'comps/artTemplate/template.min'
  ], function (image, wx, template) {
    template.helper('$', $);

    $('.js-upload-container').html(template.render('wx-upload-image-tpl', { title: '作品照片上传'}));

    image.init({
      $container: $('.js-wx-upload-image'),
      images: <?= json_encode((array) $images ?: []) ?>,
      wx: wx,
      max: 3,
      uploadUrl: $.url('wechat-image/get-wechat<?= $isCrop ? '-corp' : '' ?>-image')
    });
  });
</script>
<?= $block->end() ?>

