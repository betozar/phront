<?php

/**
 * ================================
 * VIEWS
 * ================================
 */
function require_error_page(string $page): void
{
  require_once ERR_PAGE_PATH . "/{$page}.view.php";
}

function require_page(string $page): void
{
  require_once $page;
}

function layout(string $name, array $data = []): void
{
  extract($data);

	$__layout_file__ = str_replace('.', '/', $name) . '.layout.php';

	require_once LAYOUT_PATH . "/{$__layout_file__}";
}

function partial(string $name, array $data = []): void
{
  extract($data);

  $__partial_file__ = str_replace('.', '/', $name);

  require PARTIAL_PATH . "/{$__partial_file__}.shared.php";
}
