<?php

http_only_get();
http_only_guest();

$email = flash_get('email', '');
$errors = flash_get('errors', []);

?>

<?php layout('public.header'); ?>

<h1><?=__('Login')?></h1>

<form action="/api/auth/login" method="POST">
  <label for="email"><?=__('Email Address')?></label>
  <input type="email" name="email" id="email" value="<?=$email?>">
  <br>
  <label for="password"><?=__('Password')?></label>
  <input type="password" name="password" id="password">
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