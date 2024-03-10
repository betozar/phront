<?php

/**
 * ================================
 * HTTP
 * ================================
 */
function http_request_method()
{
  return strtoupper($_SERVER['REQUEST_METHOD']);
}

function http_request_url(): string
{
  return sanitize_url($_SERVER['REQUEST_URI']);
}

function http_request_headers(): array
{
  $headers = sanitize_array(getallheaders());

  return $headers;
}

function http_request_sends_json(): bool
{
  $headers = http_request_headers();

  return isset($headers['Content-Type'])
    && $headers['Content-Type'] === 'application/json';
}

function http_request_wants_json(): bool
{
  $headers = http_request_headers();

  return isset($headers['Accept'])
    && $headers['Accept'] === 'application/json';
}

function http_request_body(): array
{
  $data = null;

  if( http_request_sends_json() ) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
  } else {
    $data = $_POST;
  }

  $data = sanitize_array($data);

  return $data;
}

function http_request_params(): array
{
  return $_SERVER[SESSION_FIELD]['REQUEST_PARAMS'];
}

function http_request_query(): array
{
  return sanitize_array($_GET);
}

function http_cookies(): array {
  return sanitize_array($_COOKIE);
}

function http_set_cookie(
  string $name, 
  string $value, 
  int $expire = 0, 
  string $path = '/', 
  string $domain = '', 
  bool $secure = false, 
  bool $httponly = false
): void {
  setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
}

function http_get_cookie(string $name): ?string {
  $cookies = http_cookies();

  return $cookies[$name] ?? null;
}

function http_has_cookie(string $name): bool {
  $cookies = http_cookies();

  return isset($cookies[$name]);
}

function http_delete_cookie(
  string $name, 
  string $path ='/', 
  string $domain = '', 
  bool $secure = false, 
  bool $httponly = false
): void {
  setcookie($name, '', time() - 3600, $path, $domain, $secure, $httponly);
  unset($_COOKIE[$name]);
}

function http_response_status(int $status): void
{
  http_response_code($status);
}

function http_response_headers(array $headers): void
{
  foreach( $headers as $key => $value )
    header("{$key}: {$value}");
}

function http_response_json(array $data): void
{
  http_response_headers([
    'Content-Type' => 'application/json'
  ]);
  echo json_encode($data);
}

function http_response_file(
  string $filepath,
  string $type,
  string $attachment_name,
  bool $exit = true
): void {
  if( !file_exists($filepath) )
    http_throw_not_found();

  http_response_headers([
    'Content-Description' => 'File Transfer',
    'Content-Type' => $type,
    'Content-Disposition' => "attachment; filename=\"{$attachment_name}\"",
    'Expires' => '0',
    'Cache-Control' => 'must-revalidate',
    'Pragma' => 'public',
    'Content-Length' => filesize($filepath)
  ]);

  readfile($filepath);

  if($exit) exit;
}

function http_redirect(string $to = ''): void
{
  header('Location: '.APP_URL."/{$to}");
  exit;
}

function http_redirect_away(string $url): void
{
  header('Location: '.$url);
}

function http_throw_not_found(bool $exit = true): void
{
  http_response_status(404);
  require_error_page('404');
  if($exit) exit;
}
