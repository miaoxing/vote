<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/vote/css/vote.css') ?>"/>
<?= $block->end() ?>

<div id="masonry" class="container-fluid masonry">
</div>

<div id="masonry-ghost" class="hide masonry-ghost">
</div>

<script type="text/html" class="js-thumbnail-item-tpl">
  <div class="thumbnail js-thumbnail">
    <a href="<%= $.url('vote-works/%s/show', id); %>">
      <div class="header-title">
        <%= name %>
      </div>

      <div class="img">
        <input type="hidden" name="image" value="<%= images[0] %>">
      </div>
    </a>

    <div class="caption">
      <div class="description text-muted"><%= description %></div>
      <div class="extra">
        <span class="vote-count">票数：<span class="vote-count-num js-vote-count"><%= voteCount %></span></span>
        <span class="vote">
          <a href="javascript:void(0)" data-id="<%= id %>" class="js-vote">
            <button class="vote-button bg-primary text-white">投票</button>
          </a>
        </span>
      </div>
    </div>

  </div>
</script>

<?= $block->js() ?>
<script>
  require([
    'comps/masonry/dist/masonry.pkgd.min',
    'plugins/app/libs/artTemplate/template.min',
    'comps/imagesloaded/imagesloaded.pkgd.min'
  ], function (Masonry, template) {
    template.helper('$', $);

    //初始化数据
    var voteWorkData = <?= json_encode($voteWorks, JSON_UNESCAPED_UNICODE); ?>;
    for (var i in voteWorkData) {
      var tpl = template.compile($('.js-thumbnail-item-tpl').html());
      var html = tpl(voteWorkData[i]);
      $('#masonry-ghost').append(html);
    }

    var masonry;
    var masNode = $('#masonry');
    var ghostNode = $('#masonry-ghost').find('.js-thumbnail');
    var ghostCount = ghostNode.length;
    var currentIndex = 0;
    var imagesLoading = false;

    // 获取新的单元
    function getNewItems() {
      var newItemContainer = $('<div/>');
      for (var i = 0; i < 8; i++) {
        if (currentIndex < ghostCount) {
          newItemContainer.append(ghostNode.get(currentIndex));
          currentIndex++;
        }
      }
      return newItemContainer.find('.js-thumbnail');
    }

    // 处理新的单元
    function processNewItems(items) {
      items.each(function () {
        var $this = $(this);
        var imgsNode = $this.find('.img');
        var imgUrl = imgsNode.find('input[type=hidden]').val();
        imgsNode.append('<img style="width:100%;height:auto;" src="' + imgUrl + '" />');
      });
    }

    // 添加新单元到瀑布流
    function appendToMasonry() {
      var items = getNewItems().css('opacity', 0);
      processNewItems(items);
      masNode.append(items);

      imagesLoading = true;
      items.imagesLoaded(function () {
        imagesLoading = false;
        items.css('opacity', 1);

        if (typeof masonry == 'undefined') {
          // 初始化
          masonry = new Masonry('#masonry', {
            itemSelector: '.js-thumbnail'
          });
        } else {
          masonry.appended(items);
        }
      });
    }

    // 初始化瀑布流
    appendToMasonry();

    $(window).scroll(function () {
      if ($(document).height() - $(window).height() - $(document).scrollTop() < 10) {
        if (!imagesLoading) {
          appendToMasonry();
        }
      }
    });

    $('.js-thumbnail').on('click', '.js-vote', function () {
      var id = $(this).data('id');
      var $this = $(this);
      $.ajax({
        loading: true,
        url: $.url('vote-works/vote'),
        data: {voteWorkId: id},
        dataType: 'json',
        type: 'post',
        success: function (ret) {
          $.msg(ret);
          if (ret.code == 1) {
            if(ret.addVoteUserCount == 1) {
              $('.js-attend-user-count').html(parseInt($('.js-attend-user-count').html()) + 1);
            }

            $('.js-all-vote-count').html(parseInt($('.js-all-vote-count').html()) + 1);
            var $num = $this.closest('.extra').find('.js-vote-count');
            $num.html(parseInt($num.html()) + 1);
          }
        }
      })
    })

  });
</script>
<?= $block->end(); ?>
