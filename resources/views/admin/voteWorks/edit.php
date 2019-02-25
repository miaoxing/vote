<?php $view->layout() ?>

<div class="page-header">
  <a class="btn btn-default float-right"
    href="<?= $url('admin/vote-works', ['voteId' => $voteWork['voteId'] ?: $e($req['voteId'])]) ?>">返回列表</a>

  <h1>
    投票管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      投票作品
    </small>
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-12">
    <form class="js-vote-work-form form-horizontal" method="post" role="form"
      action="<?= $url('admin/vote-works/' . $voteWork->getFormAction()) ?>">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="name">
          <span class="text-warning">*</span>
          作品名称
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="name" id="name" data-rule-required="true">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="username">
          姓名
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="username" id="username">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="mobile">
          电话
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="mobile" id="mobile">
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-2 control-label">
          <span class="text-warning">*</span>
          图片
        </label>

        <div class="col-sm-10">
          <input class="js-images" name="images[]" type="text" required>
          <label class="help-text">图片长宽比1:1<br>建议宽度大于等于750像素</label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="description">
          作品描述
        </label>

        <div class="col-lg-4">
          <textarea class="form-control" name="description" id="description"></textarea>
        </div>
      </div>

      <input type="hidden" name="id" id="id">
      <input type="hidden" name="voteId" id="vote-id" value="<?= $e($req['voteId']) ?>">

      <div class="clearfix form-actions form-group">
        <div class="offset-lg-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>

          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default"
            href="<?= $url('admin/vote-works', ['voteId' => $voteWork['voteId'] ?: $e($req['voteId'])]) ?>">
            <i class="fa fa-undo"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
  <!-- PAGE detail ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?= $block->js() ?>
<script>
  require(['form', 'plugins/app/libs/artTemplate/template.min', 'plugins/app/js/validation', 'plugins/admin/js/image-upload'], function () {
    var data = <?= $voteWork->toJson() ?>;
    // 初始化表单
    $('.js-vote-work-form')
      .loadJSON(data)
      .ajaxForm({
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          return $form.valid();
        },
        success: function (result) {
          $.msg(result, function () {
            if (result.code > 0) {
              window.location = $.url('admin/vote-works', {
                voteId: '<?= $voteWork['voteId'] ?: $e($req['voteId']); ?>'
              });
            }
          });
        }
      })
      .validate();

    $('.js-images').imageUpload({
      images: data.images
    });
  });
</script>
<?= $block->end() ?>
