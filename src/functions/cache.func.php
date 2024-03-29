<?php

/**
 * ================================
 * CACHING AND MINIFICATION
 * ================================
 */


/**
 * Returns a minified version of a given HTML
 */
function html_minify(string $buffer): string
{
  $search = array(
  '/(\n|^)(\x20+|\t)/',
  '/(\n|^)\/\/(.*?)(\n|$)/',
  '/\n/',
  '/\<\!--.*?-->/',
  '/(\x20+|\t)/', # Delete multispace (Without \n)
  '/\>\s+\</', # strip whitespaces between tags
  '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
  '/=\s+(\"|\')/'); # strip whitespaces between = "'

 $replace = array(
  "\n",
  "\n",
  " ",
  "",
  " ",
  "><",
  "$1>",
  "=$1");

  $buffer = preg_replace($search, $replace, $buffer);

  return trim($buffer);
}


/**
 * Starts minification for current page
 */
function html_minify_start(): void
{
	ob_start(function($buffer) {
	 return html_minify($buffer);
	});
}


/**
 * Ends minification for current page
 */
function html_minify_end(): void
{
	ob_end_flush();
}


/**
 * Generate cached view path based on the URL
 */
function cache_filename_by_url(string $url): string
{
  $url = str_replace('/', '-', $url);
  $url = str_replace('?', '-', $url);
  $url = str_replace('=', '-', $url);
  $url = str_replace('&', '-', $url);
  $url = str_replace('#', '-', $url);
  $url = trim($url, '-');

  $url = preg_replace('/-+/', '-', $url);

  return CACHE_PATH . "/".session_lang_get()."-{$url}.html";
}


/**
 * Generate cached view path based on a given name
 */
function cache_filename_by_name(string $name): string
{
  return CACHE_PATH . "/".session_lang_get()."-{$name}.html";
}


/**
 * Starts caching of the current page
 */
function cache_start(?string $page_name = null): void
{
  if(APP_DEBUG) return;

  $cache_file = null;

  if( is_null($page_name) ) 
    $cache_file = cache_filename_by_url(http_request_url());
  else
    $cache_file = cache_filename_by_name($page_name);

  if( file_exists($cache_file) )
  {
    readfile($cache_file);
    exit;
  }

  ob_start(function($buffer) use ($cache_file) {
    $buffer = html_minify($buffer);
    file_put_contents($cache_file, $buffer);
    return $buffer;
  });

}


/**
 * Ends page caching
 */
function cache_end(): void
{
  ob_end_flush();
}
