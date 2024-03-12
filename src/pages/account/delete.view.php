<?php

http_only_get();
http_only_auth();

?>

<?php layout('public.header'); ?>

<?php partial('account.navbar'); ?>

<h1><?=__('Delete Account')?></h1>

<form action="/api/account/delete" method="POST">
  <input type="submit" value="<?=__('Delete Account')?>">
</form>

<?php layout('public.footer'); ?>
