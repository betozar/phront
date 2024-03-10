<?php cache_start('404'); ?>

<?php layout('public.header'); ?>

<h1><?=__('Page Not Found')?></h1>
<a href="/"><?=__('Go Home')?></a>

<?php layout('public.footer'); ?>

<?php cache_end(); ?>
