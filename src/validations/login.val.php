<?php

function validate_email(mixed $value): ?string
{
	$name = 'Email Address';

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
	$name = 'Password';

	$err =
		vl_is_required($value, $name)
		?? vl_is_string($value, $name)
		?? vl_str_max($value, 255, $name)
		?? null;

	if(!is_null($err)) return $err;

	return null;
}

function validate_credentails(
	string $email, 
	string $password,
	PDO $db
): array|string {
	$user = users_find_by_email($db, $email);

	if(
		is_null($user)
		|| !is_null( vl_password_match($password, $user['password'], 'Password') )
	) {
		return __('Invalid Credentials');
	}

	return $user;
}
