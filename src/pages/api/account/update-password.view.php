<?php

require_once TABLE_PATH . '/users.db.php';
require_once VALIDATION_PATH . '/account.val.php';

http_only_post();
http_only_auth();

$db = db_sqlite_connect();

if( is_null($db) )
{
  flash_set('errors', [
    'password' => __('Service is unavailable')
  ]);

  http_redirect('account/edit-password');
}

$http_body = http_request_body();

$password = $http_body['password'] ?? null;
$password_confirm = $http_body['password_confirm'] ?? null;

$password_failed = validate_password($password, $password_confirm);

if( !is_null($password_failed) )
{
  flash_set('password', $password);
  flash_set('password_confirm', $password_confirm);
  flash_set('errors', [
    'password' => $password_failed
  ]);
  http_redirect('account/edit-password');
}

$updated = users_update_password_by_id(
  $db, 
  auth_get('id'), 
  ['password' => $password]
);

if( !$updated )
{
  flash_set('password', $password);
  flash_set('password_confirm', $password_confirm);
  flash_set('errors', [
    'password' => __('Account can not be updated')
  ]);
  http_redirect('account/edit-password');
}

flash_set('alert', [
  'type' => 'info',
  'message' => [
    __('Account was updated'),
    __('Some changes will be applied until you restart the session')
  ]
]);

http_redirect('account/edit-password');
