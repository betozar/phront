<?php

http_only_get();
http_only_auth();

$input = flash_get('input', []);

$password = $input['password'] ?? '';
$password_confirm = $input['password_confirm'] ?? '';
$errors = flash_get('errors', []);

?>

<?php layout('public.header'); ?>

<?php partial('account.navbar'); ?>

<h1><?=__('Edit Password')?></h1>

<form action="/api/account/update-password" method="POST">
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