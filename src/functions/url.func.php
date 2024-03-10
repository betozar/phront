<?php

/**
 * ================================
 * URL's
 * ================================
 */

function url(string $to): string
{
  return APP_URL . "/{$to}";
}

function asset(string $name): string
{
  if(
    APP_DEBUG 
    || !file_exists(VITE_MANIFEST)
  ) {
    return ASSET_URL . "/{$name}";
  }

  $manifest = json_decode(
    file_get_contents(VITE_MANIFEST),
    true
  );

  if( !isset($manifest[$name]) )
    return STATIC_URL."/{$name}";

  return STATIC_URL."/{$manifest[$name]['file']}";
}
