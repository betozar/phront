<?php

/**
 * ================================
 * SANITIZATION
 * ================================
 */


/**
 * Sanitize full special chars in a string
 */
function sanitize_full(string $str): string
{
  return filter_var(
    $str,
    FILTER_SANITIZE_FULL_SPECIAL_CHARS
  );
}


/**
 * Sanitize full special chars in an array
 */
function sanitize_array(array $array): array
{
  return filter_var_array(
    $array,
    FILTER_SANITIZE_FULL_SPECIAL_CHARS
  );
}


/**
 * Sanitize a URL
 */
function sanitize_url(string $url): string
{
  return filter_var(
    $url,
    FILTER_SANITIZE_URL
  );
}


/**
 * Sanitize a given JSON as a string and returns an array
 */
function sanitize_json(string $data): array
{
  $arr = json_decode($data, true);

  if( is_null($arr) ) return [];

  return $arr;
}
