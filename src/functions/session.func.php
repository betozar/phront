<?php

/**
 * ================================
 * SESSION
 * ================================
 */


/**
 * Initializes flash messages on the session
 */
function session_flash_start(): void
{
  if( !isset($_SESSION[SESSION_FIELD]['flash']) )
  {
    $_SESSION[SESSION_FIELD]['flash'] = [];
  }
}


/**
 * Cleans flash messages on the session
 */
function session_flash_end(): void
{
  if( isset($_SESSION[SESSION_FIELD]['flash']) )
  {
    $_SESSION[SESSION_FIELD]['flash'] = [];
  }
}


/**
 * Get all flash messages
 */
function flash_all(): array {
  return $_SESSION[SESSION_FIELD]['flash'];
}


/**
 * Checks if a session message exists
 */
function flash_has(string $key): bool
{
  return isset($_SESSION[SESSION_FIELD]['flash'][$key]);
}


/**
 * Set new flash message
 */
function flash_set(string $key, mixed $value): void
{
  $_SESSION[SESSION_FIELD]['flash'][$key] = $value;
}


/**
 * Get a flash message
 */
function flash_get(string $key, mixed $default = null): mixed
{
  return isset($_SESSION[SESSION_FIELD]['flash'][$key])
    ? $_SESSION[SESSION_FIELD]['flash'][$key]
    : $default;
}
