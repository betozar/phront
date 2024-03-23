<?php

/**
 * ================================================
 * Delete authenticated account
 * ================================================
 */

require_once TABLE_PATH . '/users.db.php';
require_once TABLE_PATH . '/user_preferences.db.php';

http_only_post();
http_only_auth();

$db = db_sqlite_connect();
$form_route = 'account/delete';
$user_id = auth_get('id');
$deleted = false;

if( is_null($db) )
{
  flash_set('errors', [
    'email' => __('Service is unavailable')
  ]);

  http_redirect($form_route);
}

user_preferences_delete($db, $user_id);

$deleted = users_delete_by_id($db, $user_id);

if(!$deleted) {
  flash_set('alert', [
    'type' => 'error',
    'message' => __('Account can not be deleted')
  ]);
  http_redirect($form_route);
}

logout();
http_redirect();
