<?php $view->layout() ?>

<div class="page-header">
  <a class="btn btn-default pull-right" href="javascript:void(0)" onclick="history.back(-1);" >返回</a>
  <h1>
    投票管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      投票用户
    </small>
  </h1>
</div>

<div class="row">
  <div class="col-12">
    <div class="table-responsive">
      <table class="js-user-table record-table table table-striped table-bordered table-hover">
        <thead>
        <tr>
          <th class="t-12">用户</th>
          <th>投票作品</th>
          <th class="t-8">投票数</th>
          <th class="t-12">投票时间</th>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
  <!-- PAGE detail ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?= $block->js() ?>
<script>
  require(['dataTable', 'jquery-deparam', 'form', 'daterangepicker'], function () {
    var $recordTable = $('.js-user-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/vote-users.json',{
          voteId:'<?= $e($req['voteId']) ?>',
          voteWorkId:'<?= $e($req['voteWorkId']) ?>'
        })
      },
      columns: [
        {
          data: 'user',
          render: function (data, type, full) {
            return template.render('user-info-tpl', full.user);
          }
        },
        {
          data: 'voteWork',
          render: function (data, type, full) {
            var html = '';
            for(var i in data.images) {
              html += '<img style="width: 50px;height: 50px;" src="'+ data.images[i] +'">' + ' ';
            }
            return html + ' ' + data.name;
          }
        },
        {
          data: 'voteCount'
        },
        {
          data: 'createTime'
        }
      ]
    });

  });
</script>
<?= $block->end() ?>

<?php require $view->getFile('@user/admin/user/richInfo.php') ?>
