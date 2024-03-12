<?php

require_once TABLE_PATH . '/users.db.php';
require_once VALIDATION_PATH . '/account.val.php';

http_only_post();
http_only_auth();

$db = db_sqlite_connect();

if( is_null($db) )
{
  flash_set('errors', [
    'email' => __('Service is unavailable')
  ]);

  http_redirect('account');
}

$http_body = http_request_body();

$name = $http_body['name'] ?? null;

$name_failed = validate_name($name);

if( !is_null($name_failed) )
{
  flash_set('name', $name);
  flash_set('errors', [
    'name' => $name_failed
  ]);
  http_redirect('account');
}

$updated = users_update_name_by_id(
  $db, 
  auth_get('id'), 
  ['name' => $name]
);

if( !$updated )
{
  flash_set('name', $name);
  flash_set('errors', [
    'name' => __('Account can not be updated')
  ]);
  http_redirect('account');
}

flash_set('alert', [
  'type' => 'info',
  'message' => [
    __('Account was updated'),
    __('Some changes will be applied until you restart the session')
  ]
]);

auth_set('name', $name);

http_redirect('account');
