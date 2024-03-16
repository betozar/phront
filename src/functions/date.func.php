<?php

/**
 * ================================
 * TIME AND DATES
 * ================================
 */


/**
 * Returns a formated string with the current date and time
 */
function date_make_now(): string
{
  return (new DateTimeImmutable)->format('Y-m-d H:i:s');
}
