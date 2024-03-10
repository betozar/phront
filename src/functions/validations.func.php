<?php

function vl_is_required(
	mixed $value, 
	string $name
): ?string {
	if(
		is_null($value)
		|| empty($value)
	) {
		return __l('errors.required', $name);
	}

	return null;
}

function vl_is_string(
	mixed $value, 
	string $name
): ?string {
	if(
		gettype($value) !== 'string'
	) {
		return __l('errors.string', $name);
	}

	return null;
}

function vl_email(
	string $value, 
	string $name
): ?string {
	if(
		!filter_var($value, FILTER_VALIDATE_EMAIL)
	) {
		return __l('errors.email', $name);
	}

	return null;
}

function vl_secure_password(
	string $value, 
	string $name
): ?string {
	$common_pwd = require TABLE_PATH.'/passwords.array.php';

	if(
		isset($common_pwd[$value])
	) {
		return __l('errors.secure_password', $name);
	}

	return null;
}

function vl_confirm(
	string $source, 
	string $confirmation, 
	string $name
): ?string {

	if(
		$password !== $confirmation
	) {
		return __l('errors.confirm', $name);
	}

	return null;
}

function vl_password_match(
	string $text,
	string $hash,
	string $name
): ?string {
	if(
		!password_verify($text, $hash)
	) {
		return __l('errors.password_match', $name);
	}

	return null;
}

function vl_is_int(
	mixed $value, 
	string $name
): ?string {
	if(
		gettype($value) !== 'integer'
	) {
		return __l('errors.int', $name);
	}

	return null;
}

function vl_is_float(
	mixed $value, 
	string $name
): ?string {
	if(
		gettype($value) !== 'double'
	) {
		return __l('errors.float', $name);
	}

	return null;
}

function vl_is_boolean(
	mixed $value, 
	string $name
): ?string {
	if(
		gettype($value) !== 'boolean'
	) {
		return __l('errors.boolean', $name);
	}

	return null;
}

function vl_str_min(
	string $value,
	int $limit,
	string $name
): ?string {
	if(
		strlen($value) < $limit
	) {
		return __l('errors.min', $name, $limit);
	}

	return null;
}

function vl_str_max(
	string $value,
	int $limit,
	string $name
): ?string {
	if(
		strlen($value) > $limit
	) {
		return __l('errors.max', $name, $limit);
	}

	return null;
}

function vl_int_min(
	int $value, 
	int $limit,
	string $name
): ?string {
	if(
		$value < $limit
	) {
		return __l('errors.min', $name, $limit);
	}

	return null;
}

function vl_int_max(
	int $value,
	int $limit, 
	string $name
): ?string {
	if(
		$value > $limit
	) {
		return __l('errors.max', $name, $limit);
	}

	return null;
}

function vl_float_min(
	float $value,
	float $limit,
	string $name
): ?string {
	if(
		$value < $limit
	) {
		return __l('errors.minf', $name, $limit);
	}

	return null;
}

function vl_float_max(
	float $value,
	float $limit,
	string $name
): ?string {
	if(
		$value > $limit
	) {
		return __l('errors.maxf', $name, $limit);
	}

	return null;
}

function vl_url(
	string $value, 
	string $name
): ?string {
	if(
		!filter_var($value, FILTER_VALIDATE_URL)
	) {
		return __l('errors.url', $name);
	}

	return null;
}

function vl_in_array(
	string $needle, 
	array $haystack, 
	string $name
): ?string {
	if(
		!in_array($needle, $haystack)
	) {
		return __l('errors.in_array', $name);
	}

	return null;
}

function vl_file_is_required(
	string $filename,
	string $name
): ?string {
	if(
		!isset($_FILES[$filename])
	) {
		return __l('errors.file_required', $name);
	}

	return null;
}

function vl_file_upload_ok(
	string $filename,
	string $name
): ?string {
	if(
		!isset($_FILES[$filename])
		|| $_FILES[$filename] === UPLOAD_ERR_OK
	) {
		return __l('errors.uploaded', $name);
	}

	return null;
}

function vl_file_max_size(
	string $filename, 
	int $bytes_size,
	string $name
): ?string {
	$limit = $bytes_size / 1_000_000;

	if( 
		!isset($_FILES[$filename])
		|| $_FILES[$filename]['size'] > $bytes_size 
	) {
		return __l('errors.max_size', $name, $limit);
	}

	return null;
}

function vl_file_types(
	string $filename, 
	array $types,
	string $name,
	string $type_name
): ?string {
	if(
		!isset($_FILES[$filename])
		|| !in_array($_FILES[$filename]['type'], $types)
	) {
		return __l('errors.file_types', $name, $type_name);
	}

	return null;
}


function vl_is_json(
	string $data, 
	string $name
): ?string {
	$arr = json_decode($data);

  if( is_null($arr) )
  {
  	return __l('errors.json', $name);
  }

  return null;
}
