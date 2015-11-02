CREATE TABLE svycka_settings (
  id         INT AUTO_INCREMENT NOT NULL,
  identifier INT      DEFAULT NULL,
  collection VARCHAR(255)       NOT NULL,
  name       VARCHAR(255)       NOT NULL,
  value      LONGTEXT DEFAULT NULL,
  PRIMARY KEY (id)
)
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci
  ENGINE = InnoDB;