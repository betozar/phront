<?php

/**
 * ================================
 * AUTH
 * ================================
 */

function login(array $user): void
{
  if( isset($user['password']) )
    unset($user['password']);

  $_SESSION[SESSION_FIELD]['auth'] = $user;
}

function logout(): void
{
  unset($_SESSION[SESSION_FIELD]['auth']);
  session_destroy();
}

function auth(): ?array
{
  return isset($_SESSION[SESSION_FIELD]['auth'])
    ? $_SESSION[SESSION_FIELD]['auth']
    : null;
}

function auth_is_active(): bool
{
  return !is_null( auth() );
}

function auth_has(string $key): bool
{
  $auth = auth();

  return auth_is_active() && isset($auth[$key]);
}

function auth_get(
  string $key, 
  mixed $default = null
): mixed {
  if( auth_is_active() && auth_has($key) ) {
    return $_SESSION[SESSION_FIELD]['auth'][$key];
  }
  return $default;
}

function auth_set(
  string $key,
  mixed $value
): void {
  if( auth_is_active() )
    $_SESSION[SESSION_FIELD]['auth'][$key] = $value;
}
