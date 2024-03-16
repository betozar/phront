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

if( is_null($db) )
{
  flash_set('errors', [
    'email' => __('Service is unavailable')
  ]);

  http_redirect('auth/edit-email');
}

$http_body = http_request_body();

$email = $http_body['email'] ?? null;

$email_failed = validate_email($email, $db);

if( !is_null($email_failed) )
{
  flash_set('email', $email);
  flash_set('errors', [
    'email' => $email_failed
  ]);
  http_redirect('account/edit-email');
}

$updated = users_update_email_by_id(
  $db, 
  auth_get('id'), 
  ['email' => $email]
);

if( !$updated )
{
  flash_set('email', $email);
  flash_set('errors', [
    'email' => __('Account can not be updated')
  ]);
  http_redirect('account/edit-email');
}

flash_set('alert', [
  'type' => 'info',
  'message' => [
    __('Account was updated'),
    __('Some changes will be applied until you restart the session')
  ]
]);

auth_set('email', $email);

http_redirect('account/edit-email');
