-- sqlite
CREATE TABLE users(
	id VARCHAR(255) NOT NULL UNIQUE,
	name VARCHAR(50) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	created_at VARCHAR(255) NOT NULL,
	updated_at VARCHAR(255) NOT NULL,
	PRIMARY KEY(id)
);

