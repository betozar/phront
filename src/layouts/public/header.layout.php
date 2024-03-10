<!DOCTYPE html>
<html lang="<?=session_lang_get()?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php if(isset($__meta__)): ?>
		<?php foreach($__meta__ as $key => $value): ?>
			<meta name="<?=$key?>" content="<?=$value?>">
		<?php endforeach; ?>
	<?php endif; ?>

	<base href="<?=APP_URL?>">
	<title><?=( $__title__ ?? APP_NAME )?></title>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

	<link rel="stylesheet" href="<?=asset("app.css")?>">
	<?php if(isset($__styles__)): ?>
		<?php foreach($__styles__ as $key => $value): ?>
			<link rel="stylesheet" href="<?=asset($value)?>">
		<?php endforeach; ?>
	<?php endif; ?>

	<script src="<?=asset("app.js")?>" defer type="module"></script>
	<?php if(isset($__scripts__)): ?>
		<?php foreach($__scripts__ as $key => $value): ?>
			<script src="<?=asset($value)?>" defer type="module"></script>
		<?php endforeach; ?>
	<?php endif; ?>

</head>
<body>

<?php partial('navbar'); ?>
