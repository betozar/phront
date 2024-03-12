-- sqlite
CREATE TABLE user_preferences(
	id VARCHAR(255) NOT NULL UNIQUE,
  user_id VARCHAR(255) NOT NULL,
  lang VARCHAR(20),
	created_at VARCHAR(255) NOT NULL,
	updated_at VARCHAR(255) NOT NULL,
	PRIMARY KEY(id)
);
