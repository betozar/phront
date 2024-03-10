<?php

/**
 * ================================
 * LANGUAGE
 * ================================
 */
function session_lang_start(): void
{
  if( !isset($_SESSION[SESSION_FIELD]['lang']) )
  {
    $_SESSION[SESSION_FIELD]['lang'] = APP_LANG_DEFAULT;
  }

  $lang = session_lang_get();

  $trans_file = LANG_PATH.'/'.$lang.'.lang.php';
  
  if( !file_exists($trans_file) )
  {
    $_SERVER[SESSION_FIELD]['trans'] = [];
    return;
  }

  $_SERVER[SESSION_FIELD]['trans'] = require($trans_file);
}

function session_lang_reset(): void
{
  $_SESSION[SESSION_FIELD]['lang'] = APP_LANG_DEFAULT;
}

function session_lang_get(): string
{
  return $_SESSION[SESSION_FIELD]['lang'] ?? APP_LANG_DEFAULT;
}

function session_lang_set(string $key): void
{
  $_SESSION[SESSION_FIELD]['lang'] = $key;
}

function __(string $key): string
{
  if( session_lang_get() === APP_LANG_DEFAULT ) 
    return $key;

  return $_SERVER[SESSION_FIELD]['trans'][$key] ?? $key;
}

function __l(string $key, ...$params): string
{
  $format = $_SERVER[SESSION_FIELD]['trans'][$key] ?? null;

  if( is_null($format) ) return $key;

  for( $i = 0; $i < count($params); ++$i )
  {
    $params[$i] = __($params[$i]);
  }

  return sprintf($format, ...$params);
}