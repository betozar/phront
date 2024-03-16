<?php

/**
 * ================================
 * VIEWS
 * ================================
 */


/**
 * Require a page located at src/errors
 */
function require_error_page(string $page): void
{
  require_once ERR_PAGE_PATH . "/{$page}.view.php";
}


/**
 * Require a page located at src/pages
 */
function require_page(string $page): void
{
  require_once $page;
}


/**
 * Require a section of a layout 
 */
function layout(string $name, array $data = []): void
{
  extract($data);

	$__layout_file__ = str_replace('.', '/', $name) . '.layout.php';

	require_once LAYOUT_PATH . "/{$__layout_file__}";
}


/**
 * Required a shared component
 */
function partial(string $name, array $data = []): void
{
  extract($data);

  $__partial_file__ = str_replace('.', '/', $name);

  require PARTIAL_PATH . "/{$__partial_file__}.shared.php";
}
