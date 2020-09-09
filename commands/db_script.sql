--Database structure

CREATE TABLE post (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug(255) NOT NULL,
    content TEXT(65000) NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id)
)

CREATE TABLE post_category(
post_id INT UNSIGNED NOT NULL,
category_id INT UNSIGNED NOT NULL,
PRIMARY KEY (post_id, category_id),
CONSTRAINT fk_post
  FOREIGN KEY (post_id)
REFERENCES post (id)
ON DELETE CASCADE
ON UPDATE RESTRICT,

CONSTRAINT fk_category
  FOREIGN KEY (category_id)
REFERENCES category (id)
ON DELETE CASCADE
ON UPDATE RESTRICT
)