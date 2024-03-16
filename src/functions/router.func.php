<?php

/**
 * ================================
 * LANGUAGE
 * ================================
 */


/**
 * Handle incoming request and returns the proper 
 * page view file based on the URL
 */
function router_get_page(): ?string
{
	$url = http_request_url();
	$url = trim($url, '/');

	$url_path = parse_url($url, PHP_URL_PATH) ?? '';
	
	if( $url_path === '/' ) $url_path = '';

	$url_page = PAGE_PATH . "/{$url_path}.view.php";
	$index_page = PAGE_PATH . "/{$url_path}/index.view.php";

	$url_exploded = explode('/', $url_path);

	$_SERVER[SESSION_FIELD]['REQUEST_PARAMS'] = $url_exploded;

	if( file_exists($url_page) )
		return $url_page;
	else if( file_exists($index_page) )
		return $index_page;
	else {
		$accum = '/';

		foreach( $url_exploded as $elm ) {
			if( empty($elm) ) continue;

			$accum .= $elm;

			$default_page = PAGE_PATH . $accum . '/_default.view.php';

			if( file_exists($default_page) )
				return $default_page;

			$accum .= '/';
		}
	}

	return null;
}
