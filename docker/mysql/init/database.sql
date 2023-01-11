USE db1
CREATE TABLE user (
  userId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  password VARCHAR(100)
) ENGINE=InnoDB;

INSERT INTO user (username, password) VALUES ('user1', 'pass1');
INSERT INTO user (username, password) VALUES ('user2', 'pass2');
INSERT INTO user (username, password) VALUES ('user3', 'pass3');
