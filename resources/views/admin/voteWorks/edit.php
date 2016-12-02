<?php $view->layout() ?>

<div class="page-header">
  <a class="btn pull-right" href="<?= $url('admin/vote-works', ['voteId' => $voteWork['voteId'] ?: $e($req['voteId'])]) ?>">返回列表</a>

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
  <div class="col-xs-12">
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
          <ul class="ace-thumbnails image-picker">
            <li class="select-image text-center">
              <h5>选择图片</h5>
              <i class="fa fa-picture-o"></i>
            </li>
          </ul>
          <label class="help-text">图片长宽比1:1<br>建议宽度大于等于640像素</label>
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
      <input type="hidden" name="voteId" id="voteId" value="<?= $e($req['voteId']) ?>">

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="btn btn-info" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>

          &nbsp; &nbsp; &nbsp;
          <a class="btn"
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

<?= $block('js') ?>
<script>
  require(['form', 'template', 'validator', 'ueditor'], function () {
    var data = <?= $voteWork->toJson() ?>;
    // 初始化表单
    $('.js-vote-work-form')
      .loadJSON(data)
      .ajaxForm({
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          if ($form.find('input[name=images\\[\\]]').length == 0) {
            $.err('请至少选择一张图片');
            return false;
          }
          return $form.valid();
        },
        success: function (result) {
          $.msg(result, function () {
            if (result.code > 0) {
              window.location = $.url('admin/vote-works', {voteId: '<?= $voteWork['voteId'] ? :$e($req['voteId']); ?>'});
            }
          });
        }
      })
      .validate();

    $('.image-picker').imagePicker(data.images);
  });
</script>
<?= $block->end() ?>
