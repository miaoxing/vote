<?php $view->layout() ?>

<div class="page-header">
  <a class="btn btn-default pull-right" href="<?= $url('admin/votes') ?>">返回列表</a>

  <h1>
    投票管理
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <form class="js-vote-form form-horizontal" method="post" role="form"
      action="<?= $url('admin/votes/' . $vote->getFormAction()) ?>">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="name">
          <span class="text-warning">*</span>
          活动名称
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="name" id="name" data-rule-required="true">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="start-time">
          <span class="text-warning">*</span>
          开始时间
        </label>

        <div class="col-lg-4">
          <input type="text" class="js-range-date-time-picker form-control" name="startTime" id="start-time"
            data-rule-required="true">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="end-time">
          <span class="text-warning">*</span>
          结束时间
        </label>

        <div class="col-lg-4">
          <input type="text" class="js-range-date-time-picker form-control" name="endTime" id="end-time"
            data-rule-required="true">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="isRepeated">
          可重复投票
        </label>

        <div class="col-lg-4">
          <label class="radio-inline">
            <input type="radio" name="isRepeated" value="1"> 是
          </label>
          <label class="radio-inline">
            <input type="radio" name="isRepeated" value="0"> 否
          </label>
        </div>
      </div>

      <div class="form-group limit-form-group">
        <label class="col-lg-2 control-label" for="chance">
          <span class="text-warning">*</span>
          投票限制
        </label>

        <div class="col-sm-2 p-r-0">
          <select id="chance-rule" name="chanceRule" class="form-control pull-left readonly-after-online">
          </select>
        </div>

        <div class="col-sm-2">
          <div class="col-sm-8">
            <input type="text" name="chances" id="chances"
              class="form-control chances pull-left text-center readonly-after-online">
          </div>
          <p class="form-control-static pull-left col-sm-4">&nbsp;次</p>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="description">
          活动描述
        </label>

        <div class="col-lg-4">
          <textarea class="form-control" name="description" id="description"></textarea>
        </div>
      </div>

      <div class="styles">
        <div class="form-group">
          <label class="col-lg-2 control-label" for="styles-cover">
            头图
          </label>

          <div class="col-lg-4">
            <div class="input-group">
              <input type="text" class="js-styles-cover form-control cover" name="styles[cover]" id="styles-cover">
              <span class="input-group-btn">
                <button class="btn btn-white" type="button">
                  <i class="fa fa-picture-o"></i>
                  选择图片
                </button>
              </span>
            </div>
          </div>
          <label class="col-lg-6 help-text" for="styles-cover">
            推荐宽度为640像素,高度不限
          </label>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="rule">
          活动规则
        </label>

        <div class="col-lg-8">
          <textarea class="js-rule" id="rule" name="rule"></textarea>
        </div>
      </div>

      <input type="hidden" name="id" id="id">

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>

          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/votes') ?>">
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
  require(['form', 'ueditor', 'template', 'validator', 'assets/dateTimePicker'], function (form) {
    form.toOptions($('#chance-rule'), <?= json_encode(wei()->vote->getRulesToOptions()) ?>, 'id', 'name');

    // 初始化表单
    $('.js-vote-form')
      .loadJSON(<?= $vote->toJson() ?>)
      .ajaxForm({
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          return $form.valid();
        },
        success: function (result) {
          $.msg(result, function () {
            if (result.code > 0) {
              window.location = $.url('admin/votes');
            }
          });
        }
      })
      .validate();

    $('.js-range-date-time-picker').rangeDateTimePicker({
      showSecond: true,
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });

    $('.js-rule').ueditor();
    $('.js-styles-cover').imageInput();
  });
</script>
<?= $block->end() ?>
