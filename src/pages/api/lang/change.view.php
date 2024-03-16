<?php

/**
 * ================================================
 * Change display language for current session
 * ================================================
 */

require_once TABLE_PATH . '/user_preferences.db.php';

http_only_post();

$body = http_request_body();

if(
  !isset($body['l'])
  || !in_array($body['l'], APP_LANG_SUPPORTED)
) {
  http_redirect_back();
}

session_lang_set($body['l']);

if( auth_is_active() ) 
{
  $db = db_sqlite_connect();

  if( !is_null($db) )
  {
    user_preferences_update(
      $db, 
      auth_get('id'), 
      [ 'lang' => $body['l'] ]
    );
  }

}

http_redirect_back();
