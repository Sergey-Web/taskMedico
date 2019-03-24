CREATE TABLE `users`
(
  `id`         INT(11) AUTO_INCREMENT,
  `email`      VARCHAR(50) NOT NULL UNIQUE,
  `password`   VARCHAR(60) NOT NULL,
  `created_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP            DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `user_id` INT(11)     NOT NULL,
  `phone`   VARCHAR(10) NOT NULL,
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

CREATE TABLE `tasks`
(
  `id`         INT(11) AUTO_INCREMENT,
  `user_id`    INT(11)     NOT NULL,
  `task`       VARCHAR(20) NOT NULL,
  `created_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `task_results`
(
  `id`         INT(11) AUTO_INCREMENT,
  `task_id`    INT(11)     NOT NULL,
  `result`     VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`task_id`) REFERENCES tasks (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

# Для успешной аунтентификации нужно поиск будет по email
CREATE INDEX users_email_pass ON users (email);
# При проверки прав пользователей проверка будет по полю access
CREATE INDEX accesses_access ON accesses (access);
# Для поиска по токену
CREATE INDEX tokens_token ON tokens (token);
# Обновление токена будет постостоянно происходить по этому 2 поля будут постоянно присутсвовать в выборке
CREATE INDEX tokens_user_id_date ON tokens (user_id, date);
