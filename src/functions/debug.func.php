<?php

/**
 * ================================
 * DEBUG
 * ================================
 */


/**
 * Dumps given variables
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


/**
 * Die and dump given variables
 */
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
