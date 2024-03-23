<?php

http_only_get();
http_only_auth();

$input = flash_get('input', []);
$email = $input['email'] ?? auth_get('email');
$errors = flash_get('errors', []);

?>

<?php layout('public.header'); ?>

<?php partial('account.navbar'); ?>

<h1><?=__('Edit Email Address')?></h1>

<form action="/api/account/update-email" method="POST">
  <label for="email"><?=__('Email Address')?></label>
  <input type="email" name="email" id="email" value="<?=$email?>">
  <br>
  <?php if(count($errors) > 0): ?>
    <?php foreach($errors as $key => $msg): ?>
      <p style="color: red;"><?=$msg?></p>
    <?php endforeach; ?>
    <br>
  <?php endif; ?>
  <input type="submit" value="<?=__('Send')?>">
</form>

<?php layout('public.footer'); ?>