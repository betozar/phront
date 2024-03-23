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
$form_route = 'account/edit-email';
$user_id = auth_get('id');
$http_body = null;
$email = null;
$email_failed = null;
$updated = false;

if( is_null($db) )
{
  flash_set('errors', [
    'email' => __('Service is unavailable')
  ]);

  http_redirect($form_route);
}

$http_body = http_request_body();
$email = $http_body['email'] ?? null;
$email_failed = validate_email($email, $db);

if( !is_null($email_failed) )
{
  flash_set('input', [
    'email' => $email
  ]);
  flash_set('errors', [
    'email' => $email_failed
  ]);
  http_redirect($form_route);
}

$updated = users_update_email_by_id(
  $db, 
  $user_id, 
  ['email' => $email]
);

if( !$updated )
{
  flash_set('input', [
    'email' => $email
  ]);
  flash_set('errors', [
    'email' => __('Account can not be updated')
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

auth_set('email', $email);

http_redirect($form_route);
