<?php

/**
 * ================================
 * SESSION
 * ================================
 */
function session_flash_start(): void
{
  if( !isset($_SESSION[SESSION_FIELD]['flash']) )
  {
    $_SESSION[SESSION_FIELD]['flash'] = [];
  }
}

function session_flash_end(): void
{
  if( isset($_SESSION[SESSION_FIELD]['flash']) )
  {
    $_SESSION[SESSION_FIELD]['flash'] = [];
  }
}

function flash_all(): array {
  return $_SESSION[SESSION_FIELD]['flash'];
}

function flash_has(string $key): bool
{
  return isset($_SESSION[SESSION_FIELD]['flash'][$key]);
}

function flash_set(string $key, mixed $value): void
{
  $_SESSION[SESSION_FIELD]['flash'][$key] = $value;
}

function flash_get(string $key, mixed $default = null): mixed
{
  return isset($_SESSION[SESSION_FIELD]['flash'][$key])
    ? $_SESSION[SESSION_FIELD]['flash'][$key]
    : $default;
}
