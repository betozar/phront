<?php

/**
 * ================================================
 * Update authenticated account
 * ================================================
 */

require_once TABLE_PATH . '/users.db.php';
require_once VALIDATION_PATH . '/account.val.php';

http_only_post();
http_only_auth();

$db = db_sqlite_connect();
$form_route = 'account/edit-password';
$user_id = auth_get('id');
$http_body = null;
$password = null;
$password_confirm = null;
$password_failed = null;
$updated = false;

if( is_null($db) )
{
  flash_set('errors', [
    'password' => __('Service is unavailable')
  ]);

  http_redirect($form_route);
}

$http_body = http_request_body();
$password = $http_body['password'] ?? null;
$password_confirm = $http_body['password_confirm'] ?? null;
$password_failed = validate_password($password, $password_confirm);

if( !is_null($password_failed) )
{
  flash_set('input', [
    'password' => $password,
    'password_confirm' => $password_confirm,
  ]);

  flash_set('errors', [
    'password' => $password_failed
  ]);

  http_redirect($form_route);
}

$updated = users_update_password_by_id(
  $db, 
  $user_id, 
  ['password' => $password]
);

if( !$updated )
{
  flash_set('input', [
    'password' => $password,
    'password_confirm' => $password_confirm,
  ]);

  flash_set('errors', [
    'password' => __('Account can not be updated')
  ]);

  http_redirect($form_route);
}

flash_set('alert', [
  'type' => 'info',
  'message' => [
    __('Account was updated'),
    __('Some changes will be applied until you restart the session')
  ]
]);

http_redirect($form_route);
