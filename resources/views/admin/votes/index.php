<?php $view->layout() ?>

<!-- /.page-header -->
<div class="page-header">
  <div class="pull-right">
    <a class="btn btn-success" href="<?= $url('admin/votes/new') ?>">添加投票活动</a>
  </div>
  <h1>
    投票管理
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <table id="record-table" class="js-vote-table table table-bordered table-hover table-center">
        <thead>
        <tr>
          <th style="width: 240px">活动名称</th>
          <th>描述</th>
          <th style="width: 180px">开始时间~结束时间</th>
          <th style="width: 90px">参与人次</th>
          <th style="width: 90px">默认</th>
          <th style="width: 160px">操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<script id="isDefaultTpl" type="text/html">
  <% if (isDefault == '1') { %>
  默认活动
  <% } else { %>
  <a href="javascript:;" class="js-set-default" data-id="<%= id %>">设为默认</a>
  <% } %>
</script>

<script id="vote-user-count-tpl" type="text/html">
  <a href="<%= $.url('admin/vote-users', {voteId : id}) %>" title="查看投票详情">
    <%= userCount %>
  </a>
</script>

<script id="tableActionsTpl" type="text/html">
  <div class="action-buttons">
    <a href="<%= $.url('votes/%s', id) %>" target="_blank" title="查看">
      <i class="fa fa-search-plus bigger-130"></i>
    </a>
    <a href="<%= $.url('admin/vote-works', {voteId:id}) %>" title="作品列表">
      <i class="fa fa-plus bigger-130"></i>
    </a>
    <a href="<%= $.url('admin/votes/%s/edit', id) %>" title="编辑">
      <i class="fa fa-edit bigger-130"></i>
    </a>
    <a class="text-danger delete-record" href="javascript:;" data-href="<%= $.url('admin/votes/%s/destroy', id) %>" title="删除">
      <i class="fa fa-trash-o bigger-130"></i>
    </a>
  </div>
</script>

<?= $block('js') ?>
<script>
  require(['dataTable', 'form', 'jquery-deparam'], function () {
    var $recordTable = $('.js-vote-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/votes.json')
      },
      columns: [
        {
          data: 'name'
        },
        {
          data: 'description'
        },
        {
          data: 'startTime',
          render: function (data, type, full) {
            return full.startTime.replace(/-/g, '.').substr(0, 10) + '~' + full.endTime.replace(/-/g, '.').substr(0, 10);
          }
        },
        {
          data: 'userCount',
          render: function (data, type, full) {
            return template.render('vote-user-count-tpl', full);
          }
        },
        {
          data: 'isDefault',
          render: function (data, type, full) {
            return template.render('isDefaultTpl', full);
          }
        },
        {
          data: 'id',
          render: function (data, type, full) {
            return template.render('tableActionsTpl', full);
          }
        }
      ]
    });

    // 设为默认
    $recordTable.on('click', '.js-set-default', function () {
      $.post($.url('admin/votes/%s/update-default', $(this).data('id'), {isDefault: 1}), function (ret) {
        $.msg(ret);
        $recordTable.reload();
      }, 'json');
    });

    $recordTable.deletable();
  });
</script>
<?= $block->end() ?>
