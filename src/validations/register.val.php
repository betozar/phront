<?php

function validate_name(?string $value): ?string
{
  $name = 'Name';

  $error =
    vl_is_required($value, $name)
    ?? vl_is_string($value, $name)
    ?? vl_str_min($value, 3, $name)
    ?? vl_str_max($value, 50, $name)
    ?? null;

  if(!is_null($error)) return $error;

  return null;
}

function validate_email(?string $value, PDO $db): ?string
{
  $name = 'Email Address';

  $error = 
    vl_is_required($value, $name)
    ?? vl_is_string($value, $name)
    ?? vl_email($value, $name)
    ?? null;

  if(!is_null($error)) return $error;

  $email_exists = users_find_by_email($db, $value);

  if(!is_null($email_exists))
    return __l('errors.exists', $name);

  return null;
}

function validate_password(?string $value, ?string $confirm): ?string
{
  $name = 'Password';

  $error = 
    vl_is_required($value, $name)
    ?? vl_str_min($value, 8, $name)
    ?? vl_str_max($value, 50, $name)
    ?? vl_secure_password($value, $name)
    ?? vl_confirm($value, $confirm, $name)
    ?? null;

  if(!is_null($error)) return $error;

  return null;
}
