<?php

function user_preferences_find(
  PDO $db,
  string $user_id
): ?array {
  $sql = 'SELECT * FROM user_preferences WHERE user_id = :user_id LIMIT 1';
	$stmt = $db->prepare($sql);

  if($stmt === false) return null;

	$executed = $stmt->execute([
		'user_id' => $user_id
	]);

	if( $executed === false ) return null;

	$item = $stmt->fetch();

	if( $item === false ) return null;

	return $item;
}

function user_preferences_store(
  PDO $db,
  string $user_id,
  array $data
): bool {
  $sql = '
    INSERT INTO user_preferences(
      id,
      user_id,
      lang,
      created_at,
      updated_at
    ) VALUES (
      :id,
      :user_id,
      :lang,
      :created_at,
      :updated_at
    )
  ';
      
  $date_now = date_make_now();

  $params = [
    'id' => uniqid(),
    'user_id' => $user_id,
    'lang' => $data['lang'],
    'created_at' => $date_now,
    'updated_at' => $date_now
  ];

  $stmt = $db->prepare($sql);

  if($stmt === false) return false;

  return $stmt->execute($params);
}

function user_preferences_update(
  PDO $db,
  string $user_id,
  array $data
): bool {
  $sql = '
	UPDATE user_preferences
	SET
		lang = :lang,
		updated_at = :updated_at
	WHERE
		user_id = :user_id
	';

	$date_now = date_make_now();

	$params = [
		'user_id' => $user_id,
		'lang' => $data['lang'],
		'updated_at' => $date_now,
	];

	$stmt = $db->prepare($sql);

  if($stmt === false) return false;

	return $stmt->execute($params);
}

function user_preferences_delete(
  PDO $db,
  string $user_id
): bool {
  $sql = 'DELETE FROM user_preferences WHERE user_id = :user_id';
	
  $stmt = $db->prepare($sql);

  if($stmt === false) return false;

	return $stmt->execute([
		'user_id' => $user_id
	]);
}
