<?php

/**
 * ================================
 * DEBUG
 * ================================
 */
function _d(mixed ...$objs): void
{
  if(!APP_DEBUG) return;

  foreach( $objs as $obj )
  {
    echo '<br><hr><pre>';
      var_dump($obj);
    echo '</pre><hr><br>';
  }
}

function _dd(mixed ...$objs): void
{
  if(!APP_DEBUG) return;

  foreach( $objs as $obj )
  {
    echo '<br><hr><pre>';
      var_dump($obj);
    echo '</pre><hr><br>';
  }

  exit;
}