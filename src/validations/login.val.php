<?php

function validate_email(mixed $value): ?string
{
	$name = 'email';

	$err = 
			 vl_is_required($value, $name) 
		?? vl_is_string($value, $name)
		?? vl_email($value, $name)
		?? null;

	if(!is_null($err)) return $err;

	return null;
}

function validate_password(mixed $value): ?string
{
	return null;
}

function validate_credentails(
	string $email, 
	string $password
): ?string {
	// return 'Invalid Credentials';
	return null;
}
