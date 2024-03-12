<?php

require_once TABLE_PATH . '/users.db.php';
require_once TABLE_PATH . '/user_preferences.db.php';
require_once VALIDATION_PATH . '/login.val.php';

http_only_post();
http_only_guest();

$db = db_sqlite_connect();

if( is_null($db) )
{
  return __('Service is unavailable');
}

$http_body = http_request_body();
$email = $http_body['email'] ?? null;
$password = $http_body['password'] ?? null;

$email_failed = validate_email($email);
$password_failed = validate_password($password);

if(
  !is_null($email_failed)
  || !is_null($password_failed)
) {
  flash_set('email', $email);

  flash_set('errors', [
    'email' => $email_failed,
    'password' => $password_failed
  ]);

  http_redirect('auth/login');
}

$user = validate_credentails($email, $password, $db);

if(
  gettype($user) === 'string'
) {
  flash_set('email', $email);

  flash_set('errors', [
    'email' => $user,
  ]);

  http_redirect('auth/login');
}

login($user);

$user_preferences = user_preferences_find($db, auth_get('id'));

if( !is_null($user_preferences) )
{
  session_lang_set($user_preferences['lang']);
}

http_redirect();
