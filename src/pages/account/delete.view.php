<?php

http_only_get();
http_only_auth();

$errors = flash_get('errors', []);

?>

<?php layout('public.header'); ?>

<?php partial('account.navbar'); ?>

<h1><?=__('Delete Account')?></h1>

<form action="/api/account/delete" method="POST">
  <input type="submit" value="<?=__('Delete Account')?>">
  <?php if(count($errors) > 0): ?>
    <?php foreach($errors as $key => $msg): ?>
      <p style="color: red;"><?=$msg?></p>
    <?php endforeach; ?>
    <br>
  <?php endif; ?>
</form>

<?php layout('public.footer'); ?>
