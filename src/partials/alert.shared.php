<?php

$alert = flash_get('alert');

?>

<?php if( $alert ): ?>
  <?php if( gettype($alert['message']) === 'string' ): ?>
    <p class="alert-<?=$alert['type']?>"><?=$alert['message']?></p>
  <?php else: ?>
    <?php foreach( $alert['message'] as $msg ): ?>
      <p class="alert-<?=$alert['type']?>"><?=$msg?></p>
    <?php endforeach; ?>
  <?php endif; ?>
<?php endif; ?>
