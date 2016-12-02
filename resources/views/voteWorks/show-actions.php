<div class="m-a-sm js-submit">
  <a class="btn btn-block btn-primary js-vote" href="javascript:;void(0)" data-id="<?= $voteWork['id'] ?>">投 票</a>
  <a class="btn btn-block btn-default" href="<?= $url->full('votes/%s', $voteWork['voteId']) ?>">更多作品</a>
</div>

<?= $block('js') ?>
<script>
  $('.js-submit').on('click', '.js-vote', function () {
    var id = $(this).data('id');
    $.ajax({
      loading: true,
      url: $.url('vote-works/vote'),
      data: {voteWorkId: id},
      dataType: 'json',
      type: 'post',
      success: function (ret) {
        $.msg(ret);
        if(ret.code == 1) {
          if(ret.addVoteWorkUserCount == 1) {
            $('.js-vote-work-user-count').html(parseInt($('.js-vote-work-user-count').html()) + 1);
          }

          $('.js-vote-count').html(parseInt($('.js-vote-count').html()) + 1);

          if($('.js-lastCount').html() > 0) {
            $('.js-lastCount').html(parseInt($('.js-lastCount').html()) - 1);
          }

          if($('.js-lastCount').html() == 0 && $('.js-rank').html() > 1) {
            $('.js-rank').html(parseInt($('.js-rank').html()) - 1);
          }
        }
      }
    })
  })
</script>
<?= $block->end(); ?>
