CREATE TABLE `users`
(
  `id`         INT(11) AUTO_INCREMENT,
  `email`      VARCHAR(50) NOT NULL UNIQUE,
  `password`   VARCHAR(60) NOT NULL,
  `created_at` DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at`  DATETIME             DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `accesses`
(
  `id`      INT(11) AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `access`  TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `phones`
(
  `id`      INT(11) AUTO_INCREMENT,
  `user_id` INT(11)    NOT NULL,
  `phone`   TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `names`
(
  `id`      INT(11) AUTO_INCREMENT,
  `user_id` INT(11)     NOT NULL,
  `name`    VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `tokens`
(
  `id`      INT(11) AUTO_INCREMENT,
  `user_id` INT(11)     NOT NULL,
  `token`   VARCHAR(36) NOT NULL,
  `date`    TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

# Для успешной аунтентификации нужно поиск будет по email
CREATE INDEX users_email_pass ON users (email);
# При проверки прав пользователей проверка будет по полю access
CREATE INDEX accesses_access ON accesses (access);
# Под вопросом я не знаю как это API бы использовалось
CREATE INDEX phones_phone ON phones (phone);
# Так же под вопросом
CREATE INDEX names_name ON names (name);
# Обновление токена будет постостоянно происходить по этому 2 поля будут постоянно присутсвовать в выборке
CREATE INDEX tokens_user_id_date ON tokens (user_id, date);
