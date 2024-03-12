<?php

function date_make_now(): string
{
  return (new DateTimeImmutable)->format('Y-m-d H:i:s');
}
