<?php

/**
 * ================================
 * HTTP
 * ================================
 */


// HTTP status codes
define('HTTP_OK', 200);
define('HTTP_CREATED', 201);
define('HTTP_ACCEPTED', 202);
define('HTTP_NO_CONTENT', 204);
define('HTTP_REDIRECT_PERMANENTLY', 301);
define('HTTP_REDIRECT', 303);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_UNAUTHORIZED', 401);
define('HTTP_FORBIDDEN', 403);
define('HTTP_NOT_FOUND', 404);
define('HTTP_METHOD_NOT_ALLOWED', 405);
define('HTTP_NOT_ACCEPTABLE', 406);
define('HTTP_INTERNAL_SERVER_ERROR', 500);
define('HTTP_NOT_IMPLEMENTED', 501);


/**
 * Returns request method
 */
function http_request_method()
{
  return strtoupper($_SERVER['REQUEST_METHOD']);
}


/**
 * Returns request url
 */
function http_request_url(): string
{
  return sanitize_url($_SERVER['REQUEST_URI']);
}


/**
 * Returns request method
 */
function http_referer(): string
{
  return sanitize_url($_SERVER['HTTP_REFERER']);
}


/**
 * Returns request headers
 */
function http_request_headers(): array
{
  $headers = sanitize_array(getallheaders());

  return $headers;
}


/**
 * Checks if the a json was sent from the client
 */
function http_request_sends_json(): bool
{
  $headers = http_request_headers();

  return isset($headers['Content-Type'])
    && $headers['Content-Type'] === 'application/json';
}


/**
 * Checks if the client wants a response in json format
 */
function http_request_wants_json(): bool
{
  $headers = http_request_headers();

  return isset($headers['Accept'])
    && $headers['Accept'] === 'application/json';
}


/**
 * Returns request body regardless if is a json or a form submitted
 */
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


/**
 * Returns URL params, mostly for _default.view.php files
 */
function http_request_params(): array
{
  return $_SERVER[SESSION_FIELD]['REQUEST_PARAMS'];
}


/**
 * Returns sanitized $_GET array
 */
function http_request_query(): array
{
  return sanitize_array($_GET);
}


/**
 * Returns sanitized $_COOKIE's
 */
function http_cookies(): array {
  return sanitize_array($_COOKIE);
}


/**
 * Set new cookie
 */
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


/**
 * Get a cookie based on its name
 */
function http_get_cookie(string $name): ?string {
  $cookies = http_cookies();

  return $cookies[$name] ?? null;
}


/**
 * Checks if a cookie exists
 */
function http_has_cookie(string $name): bool {
  $cookies = http_cookies();

  return isset($cookies[$name]);
}


/**
 * Delete a cookie
 */
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


/**
 * Set response status
 */
function http_response_status(int $status): void
{
  http_response_code($status);
}


/**
 * Set response headers
 */
function http_response_headers(array $headers): void
{
  foreach( $headers as $key => $value )
    header("{$key}: {$value}");
}


/**
 * Send a json response
 */
function http_response_json(array $data): void
{
  http_response_headers([
    'Content-Type' => 'application/json'
  ]);
  echo json_encode($data);
}


/**
 * Send a file response
 */
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


/**
 * Redirect to another page inside the application
 */
function http_redirect(string $to = ''): void
{
  header('Location: '.APP_URL."/{$to}");
  exit;
}


/**
 * Redirect to another domain
 */
function http_redirect_away(string $url): void
{
  header('Location: '.$url);
}


/**
 * Redirect to the previous URL
 */
function http_redirect_back(): void
{
  header('Location: '.http_referer());
  exit;
}


/**
 * Displays Not Found view
 */
function http_throw_not_found(bool $exit = true): void
{
  http_response_status(404);
  
  if( http_request_method() === 'GET' )
    require_error_page('404');
  
  if($exit) exit;
}


/**
 * Only GET requests are allowed
 */
function http_only_get(): void
{
  if( http_request_method() !== 'GET' )
  {
    http_throw_not_found();
  }
}


/**
 * Only GET requests are allowed
 */
function http_only_post(): void
{
  if( http_request_method() !== 'POST' )
  {
    http_throw_not_found();
  }
}


/**
 * Only Authenticated requests are allowed
 */
function http_only_auth(): void
{
  if( !auth_is_active() )
  {
    http_throw_not_found();
  }
}


/**
 * Only Unauthenticated requests are allowed
 */
function http_only_guest(): void
{
  if( auth_is_active() )
  {
    http_throw_not_found();
  }
}
