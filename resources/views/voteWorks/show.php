<?php $view->layout() ?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/vote/css/vote.css') ?>"/>
<?= $block->end() ?>

<?php require $view->getFile('vote:voteWorks/show-images.php') ?>
<?php require $view->getFile('vote:voteWorks/show-body.php') ?>
<?php require $view->getFile('vote:voteWorks/show-actions.php') ?>

