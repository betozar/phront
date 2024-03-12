<?php

http_only_get();
http_only_guest();

$name = flash_get('name', '');
$email = flash_get('email', '');
$password = flash_get('password', '');
$password_confirm = flash_get('password_confirm', '');
$errors = flash_get('errors', []);

?>

<?php layout('public.header'); ?>

<h1><?=__('Register')?></h1>

<form action="/api/auth/register" method="POST">
  <label for="name"><?=__('Name')?></label>
  <input type="text" name="name" id="name" value="<?=$name?>">
  <br>
  <label for="email"><?=__('Email Address')?></label>
  <input type="email" name="email" id="email" value="<?=$email?>">
  <br>
  <label for="password"><?=__('Password')?></label>
  <input type="password" name="password" id="password" value="<?=$password?>">
  <br>
  <label for="password_confirm"><?=__('Confirm Password')?></label>
  <input type="password" name="password_confirm" id="password_confirm" value="<?=$password_confirm?>">
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