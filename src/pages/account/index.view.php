<?php

http_only_get();
http_only_auth();

$input = flash_get('input', []);

$name = $input['name'] ?? auth_get('name');
$errors = flash_get('errors', []);

?>

<?php layout('public.header'); ?>

<?php partial('account.navbar'); ?>

<h1><?=__('Edit Account')?></h1>

<form action="/api/account/update" method="POST">
  <label for="name"><?=__('Name')?></label>
  <input type="text" name="name" id="name" value="<?=$name?>">
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