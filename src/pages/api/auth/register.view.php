<?php

require_once TABLE_PATH . '/users.db.php';
require_once TABLE_PATH . '/user_preferences.db.php';
require_once VALIDATION_PATH . '/register.val.php';

http_only_post();
http_only_guest();

$db = db_sqlite_connect();

if( is_null($db) )
{
  flash_set('errors', [
    'email' => __('Service is unavailable')
  ]);

  http_redirect('auth/register');
}

$http_body = http_request_body();

$name = $http_body['name'] ?? null;
$email = $http_body['email'] ?? null;
$password = $http_body['password'] ?? null;
$password_confirm = $http_body['password_confirm'] ?? null;

$name_failed = validate_name($name);
$email_failed = validate_email($email, $db);
$password_failed = validate_password($password, $password_confirm);

if(
  !is_null($name_failed)
  || !is_null($email_failed)
  || !is_null($password_failed)
) {
  flash_set('name', $name);
  flash_set('email', $email);
  flash_set('password', $password);
  flash_set('password_confirm', $password_confirm);

  flash_set('errors', [
    'name' => $name_failed,
    'email' => $email_failed,
    'password' => $password_failed
  ]);

  http_redirect('auth/register');
}

$stored = users_store($db, [
  'name' => $name,
  'email' => $email,
  'password' => $password,
]);

if( !$stored )
{
  flash_set('errors', [
    'name' => __('Account can not be created')
  ]);
  http_redirect('auth/register');
}

$user = users_find_by_email($db, $email);

if( !is_null($user) )
{
  user_preferences_store(
    $db, 
    $user['id'], 
    [
      'lang' => session_lang_get()
    ]
  );
}

flash_set('alert', [
  'type' => 'info',
  'message' => __('New account was created')
]);

http_redirect('auth/register');
