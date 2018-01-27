<?php $view->layout() ?>

<div class="page-header">
  <h1>
    功能设置
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <form action="<?= $url('admin/vote-settings/update') ?>" class="js-setting-form form-horizontal" method="post"
      role="form">
      <div class="form-group">
        <label class="col-lg-2 control-label" for="isOpen">
          是否允许报名
        </label>

        <div class="col-lg-4">
          <label class="radio-inline">
            <input type="radio" class="js-vote-is-open" name="settings[vote.isOpen]" value="1"> 开启
          </label>
          <label class="radio-inline">
            <input type="radio" class="js-vote-is-open" name="settings[vote.isOpen]" value="0"> 关闭
          </label>
        </div>

      </div>

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
        </div>
      </div>
    </form>
  </div>
  <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?= $block->js() ?>
<script>
  require(['form', 'validator'], function (form) {
    $('.js-setting-form')
      .loadJSON(<?= json_encode(['js-vote-is-open' => $setting('vote.isOpen', '1')]) ?>)
      .ajaxForm({
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          return $form.valid();
        }
      })
      .validate();
  });
</script>
<?= $block->end() ?>
