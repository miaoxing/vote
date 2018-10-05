<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/css/filter.css') ?>"/>
<?= $block->end() ?>

<div class="page-header">
  <div class="pull-right">
    <a class="btn btn-success" href="<?= $url('admin/vote-works/new', ['voteId' => $e($req['voteId'])]) ?>">添加投票作品</a>
    <a class="btn btn-default" href="<?= $url('admin/votes') ?>">返回活动列表</a>
  </div>

  <h1>
    投票管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      投票作品
    </small>
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <form class="js-vote-work-form form-horizontal filter-form" role="form">
        <div class="well form-well m-b">
          <div class="form-group form-group-sm">

            <label class="col-md-1 control-label" for="name">作品名称：</label>

            <div class="col-md-3">
              <input type="text" class="form-control" id="name" name="name">
            </div>

          </div>
        </div>
      </form>

      <table id="record-table" class="js-vote-work-table table table-bordered table-hover table-center">
        <thead>
        <tr>
          <th class="t-12">用户</th>
          <th class="t-8">姓名</th>
          <th class="t-8">电话</th>
          <th class="t-8">作品名称</th>
          <th class="t-8">图片</th>
          <th>描述</th>
          <th class="t-4">投票人数</th>
          <th class="t-4">投票数</th>
          <th class="t-12">操作</th>
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

<script id="vote-user-count-tpl" type="text/html">
  <a href="<%= $.url('admin/vote-users', {voteWorkId : id}) %>" title="查看投票详情">
    <%= voteUserCount %>
  </a>
</script>

<script id="tableActionsTpl" type="text/html">
  <div class="action-buttons">
    <a href="<%= $.url('vote-works/%s', id) %>" target="_blank" title="查看">
      <i class="fa fa-search-plus bigger-130"></i>
    </a>
    <a href="<%= $.url('admin/vote-works/%s/edit', id) %>" title="编辑">
      <i class="fa fa-edit bigger-130"></i>
    </a>
    <a class="text-danger delete-record" href="javascript:" data-href="<%= $.url('admin/vote-works/%s/destroy', id) %>"
      title="删除">
      <i class="fa fa-trash-o bigger-130"></i>
    </a>
  </div>
</script>
<?php require $view->getFile('@user/admin/user/richInfo.php') ?>

<?= $block->js() ?>
<script>
  require(['dataTable', 'jquery-deparam', 'form'], function () {
    $('.js-vote-work-form').loadParams().update(function () {
      $recordTable.reload($(this).serialize(), false);
    });

    var $recordTable = $('.js-vote-work-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/vote-works.json', {voteId: '<?= $e($req['voteId']) ?>'})
      },
      aaSorting: [[5, 'desc']],
      columns: [
        {
          data: 'user',
          render: function (data, type, full) {
            return template.render('user-info-tpl', full.user);
          }
        },
        {
          data: 'username'
        },
        {
          data: 'mobile'
        },
        {
          data: 'name'
        },
        {
          data: 'images',
          sClass: 'text-left',
          render: function (data, type, full) {
            var html = '';
            for (var i in data) {
              html += '<img style="width: 50px;height: 50px; margin-left:3px;" src="' + data[i] + '">';
            }
            return html;
          }
        },
        {
          data: 'description'
        },
        {
          data: 'voteUserCount',
          bSortable: true,
          render: function (data, type, full) {
            return template.render('vote-user-count-tpl', full);
          }
        },
        {
          data: 'voteCount',
          bSortable: true
        },
        {
          data: 'id',
          render: function (data, type, full) {
            return template.render('tableActionsTpl', full);
          }
        }
      ]
    });

    $recordTable.deletable();
  });
</script>
<?= $block->end() ?>
