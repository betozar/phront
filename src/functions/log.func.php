<?php

function _log(string $message, ?string $default = null): void {
  $filename = $default ?? date('Y_m_d').'_phront';
  
  $log_file = sprintf(
    '%s/%s.log', 
    LOG_PATH, 
    $filename
  );

  $message = sprintf(
    "[%s]: %s\n", 
    date('Y-m-d h:i:s'), 
    $message
  );
  
  file_put_contents(
    $log_file, 
    $message,
    FILE_APPEND
  );
}
