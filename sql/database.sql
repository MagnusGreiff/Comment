DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS Users;


/*USE anaxdb;*/


SET NAMES utf8;

-- TODO: Add user table - link user to post
-- TODO: Update Comments and Post and add like userId to link users to there comments or posts sp they can remove them.

CREATE TABLE Posts (
  id        INT NOT NULL AUTO_INCREMENT,
  posttitle VARCHAR(30),
  postname  VARCHAR(100),
  posttext  TEXT(2499),

  PRIMARY KEY (id)

);


CREATE TABLE Comments (
  idcomment   INT NOT NULL AUTO_INCREMENT,
  commenttext TEXT(2499),
  idpost      INT,
  postuser    VARCHAR(100),

  PRIMARY KEY (idcomment),

  FOREIGN KEY (idpost) REFERENCES Posts (id)

);


INSERT INTO Posts (posttitle, postname, posttext) VALUE ("some title", "m@m.com", "blablablalbvlalfldspofksdpofksdop"),
  ("post2", "hej@ööfld.com", "some post about something random");
INSERT INTO Comments (commenttext, idpost, postuser)
  VALUE ("jfsdsjifdsjifdsjifdjifdsio", "1", "some@f.com"), ("jfkldsjflksdjklfsqq", "1", "hej@d.com"),
  ("fsdfsdf", "2", "l@lc.com"), ("fjdsoifjiosd", "2", "ööö@födö.com");

-- SELECT * FROM Comments;


DELIMITER //

DROP PROCEDURE IF EXISTS CheckComment //
CREATE PROCEDURE CheckComment(
  post INT
)
  BEGIN
    SELECT
      P.id        AS `post id`,
      P.posttitle AS `Title`,
      P.posttext  AS `Text`,
      P.postname  AS `Name`,
      C.idcomment,
      C.commenttext,
      C.postuser  AS `Author`,
      C.idpost
    FROM Comments AS C
      INNER JOIN Posts AS P ON C.idpost = P.id
    WHERE C.idpost = post
    GROUP BY C.idcomment;
    COMMIT;
  END
//

DELIMITER ;

-- SELECT P.id as `post id`, P.posttext as `Text`, P.postname AS `Name`, C.idcomment, C.commenttext, C.idpost FROM Comments as C
-- INNER JOIN Posts as P on C.idpost = P.id
-- GROUP BY C.idcomment;

-- SELECT P.id, P.postname, P.posttext FROM Posts AS P
-- INNER JOIN Comments as C on P.id = C.idpost
-- GROUP BY P.id;


CREATE TABLE Users (
  `id`          INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `name`        VARCHAR(100)                       NOT NULL,
  `email`       VARCHAR(100)                       NOT NULL UNIQUE,
  `age`         INTEGER(3)                         NOT NULL,
  `password`    VARCHAR(255)                       NOT NULL,
  `permissions` VARCHAR(5) DEFAULT 'user',
  `created`     DATETIME,
  `updated`     DATETIME,
  `deleted`     DATETIME,
  `active`      DATETIME
)
  ENGINE INNODB
  CHARACTER SET utf8
  COLLATE utf8_swedish_ci;


INSERT INTO Users (name, email, age, password, permissions) VALUES ("Admin", "admin@admin.com", 20,
                                                                    "$2y$10$lB4EEYcScF0u0VJZgdqruOcFWg1XN8m.ilmtObh3vusjiS2JejgoG", "admin"), ("Doe", "doe@doe.com", 20,
                                                                                                                                               "$2y$10$6yJKxW6dmaOyACY9AVyZwemFnlKr9NDlO2wU.DbV.HTJ.tpwt0liy", "user");
