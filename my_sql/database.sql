CREATE DATABASE les15;

CREATE TABLE users (
    id INT(11) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL);

CREATE TABLE news (
    id INT(11) NOT NULL PRIMARY KEY,
    item VARCHAR(555) NOT NULL,
    user_id INT(11) NOT NULL,
    date DATETIME NOT NULL);

ALTER TABLE news ADD CONSTRAINT FK_ONE FOREIGN KEY (user_id) REFERENCES users (id);

INSERT INTO users (id, `name`,email) VALUES (1, 'ivan','ivanov@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (2, 'anna','anna@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (3, 'oleh','oleh@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (4, 'tamara','tamara@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (5, 'mitrofan','mitrofan@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (6, 'maria','maria@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (7, 'stepan','stepan@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (8, 'olha','olha@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (9, 'svitlana','svitlana@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (10, 'vlad','vlad@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (11, 'roman','roman@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (12, 'galina','galina@gmail.com');
INSERT INTO users (id, `name`,email) VALUES (13, 'irina','irina@gmail.com');

INSERT INTO news (id, item, user_id, date) VALUES (1, 'Many people are fond of pets.',12, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (2, 'They keep different animals and birds as pets.',1, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (3, 'More often they are dogs, cats, hamsters, guinea-pigs, parrots and fish.',12, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (4, 'As for me I like parrots.',13, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (5, 'They are my favourite pets.',11, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (6, 'They are clever and nice.',11, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (7, 'I’ve got a parrot.',7, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (8, 'His name is Kesha.',12, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (9, 'He’s not big, he’s little.',12, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (10, 'He has got a small head, a yellow beak, a short neck, two beautiful wings and a long tail.',3, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (11, 'He lives in a cage.',4, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (12, 'I teach him to talk. ',6, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (13, 'He knows many words and can speak well.',5, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (14, 'He can answer to his name.',7, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (15, 'I take care of my pet.',8, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (16, 'I give him food and water every day.',8, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (17, 'He likes fruit and vegetables.',9, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (18, 'He likes to fly, play and talk.',9, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (19, 'I love him very much.',10, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (20, 'He is a member of our family.',13, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (21, 'He’s blue.',13, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (22, 'My name is Helen.',12, NOW());
INSERT INTO news (id, item, user_id, date) VALUES (23, 'So we are a family of four.',2, NOW());


SELECT users.id, users.`name`, news.item
FROM users JOIN news
ON users.id = news.user_id GROUP BY user_id ORDER BY RAND() LIMIT 7;

