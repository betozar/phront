<?php

require_once TABLE_PATH . '/users.db.php';
require_once TABLE_PATH . '/user_preferences.db.php';

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

user_preferences_delete($db, auth_get('id'));

$deleted = users_delete_by_id($db, auth_get('id'));

if(!$deleted) {
  flash_set('alert', [
    'type' => 'error',
    'message' => __('Account can not be deleted')
  ]);
}  else {
  logout();
}

http_redirect();
