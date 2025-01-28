CREATE TABLE users(
    id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(46) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW()
)

CREATE TABLE posts(
    id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    `image` VARCHAR(255),
    body TEXT NOT NULL,
    user_id INTEGER UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    FOREIGN KEY(user_id) REFERENCES users(id)
)

INSERT INTO users(name, email, password) VALUES('test user', 'user@example.com', '123456');
INSERT INTO posts(title, body, user_id,`image`) VALUES('test post one', 'this is a test post', 1,'i.jpg'),
 ('test post two', 'this is a test post', 1,'2.jpg'),
    ('test post three', 'this is a test post', 1,'3.jpg');

