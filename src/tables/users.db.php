<?php

/**
 * ================================
 * TABLE: users
 * ================================
 */


/**
 * Find record by id
 */
function users_find_by_id(
	PDO $db, 
	string $id
): ?array {
	$sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
	$stmt = $db->prepare($sql);

	if($stmt === false) return null;

	$executed = $stmt->execute([
		'id' => $id
	]);

	if( $executed === false ) return null;

	$item = $stmt->fetch();

	if( $item === false ) return null;

	return $item;
}


/**
 * Find record by email
 */
function users_find_by_email(
	PDO $db, 
	string $email
): ?array {
	$sql = 'SELECT * FROM users WHERE email = :email LIMIT 1';
	$stmt = $db->prepare($sql);

	if($stmt === false) return null;

	$executed = $stmt->execute([
		'email' => $email
	]);

	if( $executed === false ) return null;

	$item = $stmt->fetch();

	if( $item === false ) return null;

	return $item;
}


/**
 * Store new record
 */
function users_store(
	PDO $db, 
	array $data
): bool {
	$sql = '
	INSERT INTO 
	users(
		id, 
		name, 
		email, 
		password, 
		created_at, 
		updated_at
	) VALUES(
		:id, 
		:name, 
		:email, 
		:password, 
		:created_at, 
		:updated_at
	)';

	$date_now = date_make_now();

	$params = [
		'id' => uniqid(),
		'name' => $data['name'],
		'email' => $data['email'],
		'password' => password_hash(
			$data['password'], 
			PASSWORD_DEFAULT
		),
		'created_at' => $date_now,
		'updated_at' => $date_now,
	];

	$stmt = $db->prepare($sql);

	if($stmt === false) return false;

	return $stmt->execute($params);
}


/**
 * Update record name field by id
 */
function users_update_name_by_id(
	PDO $db, 
	string $id,
	array $data
): bool {
	$sql = '
	UPDATE users
	SET
		name = :name,
		updated_at = :updated_at
	WHERE
		id = :id
	';

	$date_now = date_make_now();

	$params = [
		'id' => $id,
		'name' => $data['name'],
		'updated_at' => $date_now,
	];

	$stmt = $db->prepare($sql);

	if($stmt === false) return false;

	return $stmt->execute($params);
}


/**
 * Update record email field by id
 */
function users_update_email_by_id(
	PDO $db, 
	string $id,
	array $data
): bool {
	$sql = '
	UPDATE users
	SET
		email = :email,
		updated_at = :updated_at
	WHERE
		id = :id
	';

	$date_now = date_make_now();

	$params = [
		'id' => $id,
		'email' => $data['email'],
		'updated_at' => $date_now,
	];

	$stmt = $db->prepare($sql);

	if($stmt === false) return false;

	return $stmt->execute($params);
}


/**
 * Update record password field by id
 */
function users_update_password_by_id(
	PDO $db, 
	string $id,
	array $data
): bool {
	$sql = '
	UPDATE users
	SET
		password = :password,
		updated_at = :updated_at
	WHERE
		id = :id
	';

	$date_now = date_make_now();

	$params = [
		'id' => $id,
		'password' => password_hash(
			$data['password'], 
			PASSWORD_DEFAULT
		),
		'updated_at' => $date_now,
	];

	$stmt = $db->prepare($sql);

	if($stmt === false) return false;

	return $stmt->execute($params);
}


/**
 * Delete record by id
 */
function users_delete_by_id(
	PDO $db, 
	string $id
): bool {
	$sql = 'DELETE FROM users WHERE id = :id';
	
	$stmt = $db->prepare($sql);

	if($stmt === false) return false;

	return $stmt->execute([
		'id' => $id
	]);
}
