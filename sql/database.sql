DROP TABLE IF EXISTS CommentComments;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Post2Cat;
DROP TABLE IF EXISTS PostCategory;
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Book;


/*USE anaxdb;*/


SET NAMES utf8;

-- TODO: Add user table - link user to post
-- TODO: Update Comments and Post and add like userId to link users to there comments or posts sp they can remove them.

CREATE TABLE Posts (
  id        INT NOT NULL AUTO_INCREMENT,
  posttitle VARCHAR(50),
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

CREATE TABLE CommentComments (
    idcommentc INT NOT NULL AUTO_INCREMENT,
    textcomment text(2499),
    idcommentcomment INT,
    postuser VARCHAR(100),

    PRIMARY KEY (idcommentc),

    FOREIGN KEY (idcommentcomment) REFERENCES Comments (idcomment)
);


CREATE TABLE PostCategory (
  id INT auto_increment,
  category varchar(30),

  primary key (id)
);

CREATE TABLE Post2Cat (
  postid INT,
  catid INT
);



INSERT INTO Posts (posttitle, postname, posttext) VALUE ("some title", "admin@admin.com", "blablablalbvlalfldspofksdpofksdop"),
  ("post2", "admin@admin.com", "some post about something random");
INSERT INTO Comments (commenttext, idpost, postuser)
  VALUE ("jfsdsjifdsjifdsjifdjifdsio", 1, "doe@doe.com"), ("jfkldsjflksdjklfsqq", 1, "doe@doe.com"),
  ("fsdfsdf", 2, "admin@admin.com"), ("fjdsoifjiosd", 2, "admin@admin.com");
INSERT INTO CommentComments (textcomment, idcommentcomment, postuser) VALUE ("hejsan men me", 1, "doe@doe.com"), ("men", 2, "admin@admin.com"), ("tjena", 2, "doe@doe.com"), ("jhejhejhejhejhejhejhejhejhejhej", 2, "admin@admin.com");


INSERT INTO PostCategory (category)
VALUES  ("SQL"), ("PHP");

INSERT INTO Post2Cat (postid, catid)
VALUES (1,1), (2,2), (2,1);



-- DROP VIEW IF EXISTS VPost;
-- CREATE VIEW VPost as SELECT P.id as 'postid', P.posttitle as 'posttitle', P.posttext as 'posttext', P.postname as 'postname', group_concat(category) as Category FROM Posts as P
--   INNER JOIN Post2Cat as P2C ON P.id = P2C.post_id
--   INNER JOIN PostCategory as PC on PC.id = P2C.cat_id
-- GROUP BY P.id ORDER BY P.id;

DELIMITER //

DROP PROCEDURE IF EXISTS VPost //
CREATE PROCEDURE VPost(
    checkWhere varchar(5),
    checkValue int,
    checkCategory varchar(5),
    category varchar(200),
    orderBy varchar(4)
)
BEGIN
    IF (checkWhere = 'true') then
        select p.id postid,
          p.posttitle posttitle,
          p.posttext posttext,
          p.postname postname,
          c.category Category
        from Posts p
        inner join Post2Cat p2c
          on p.id = p2c.postid
        inner join PostCategory c
          on p2c.catid = c.id
        where p.id = checkValue;
    ELSEIF (checkCategory = 'true') then
        select p.id postid,
          p.posttitle posttitle,
          p.posttext posttext,
          p.postname postname,
          c.category Category
        from Posts p
        inner join Post2Cat p2c
          on p.id = p2c.postid
        inner join PostCategory c
          on p2c.catid = c.id
          where c.category = category;
        -- SELECT * FROM VPost WHERE Category = category;
    ELSEIF (orderBy = 'desc') then
        select p.id postid,
          p.posttitle posttitle,
          p.posttext posttext,
          p.postname postname,
          c.category Category
        from Posts p
        inner join Post2Cat p2c
          on p.id = p2c.postid
        inner join PostCategory c
          on p2c.catid = c.id
        order by p.id DESC;
    ELSE
        select p.id postid,
          p.posttitle posttitle,
          p.posttext posttext,
          p.postname postname,
          c.category Category
        from Posts p
        inner join Post2Cat p2c
          on p.id = p2c.postid
        inner join PostCategory c
          on p2c.catid = c.id;
    END IF;
END
//


DROP PROCEDURE IF EXISTS VCategory;
CREATE PROCEDURE VCategory(
    postid int
)
BEGIN
    select p.id postid,
      group_concat(c.category) Category
      -- group_concat(c.category) gcategory
    from Posts p
    inner join Post2Cat p2c
      on p.id = p2c.postid
    inner join PostCategory c
      on p2c.catid = c.id
      where p.id = postid
      group by p.id order by p.id;
END
//

DROP PROCEDURE IF EXISTS PopularTags;
CREATE PROCEDURE PopularTags(
)
BEGIN
    SELECT catid, count(catid) as count FROM Post2Cat GROUP BY catid order by count desc LIMIT 5;
END
//


DROP PROCEDURE IF EXISTS GetPostCategory;
CREATE PROCEDURE GetPostCategory(
)
BEGIN
    SELECT PC.Category, P2C.catid as catid, count(P2C.catid) as count FROM PostCategory as PC
    INNER JOIN Post2Cat as P2C ON PC.id = P2C.catid group by PC.id;
END
//


DELIMITER ;

-- Call VPost("false", 1, 'true', 'PHP' , null);

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

DELIMITER //

DROP PROCEDURE IF EXISTS GetAllCommentsFromSpecific //
CREATE PROCEDURE GetAllCommentsFromSpecific(
    postuser VARCHAR(255)
)
  BEGIN
    SELECT
      C.idcomment,
      C.commenttext,
      C.postuser,
      C.idpost
    FROM Comments as C
        INNER JOIN Posts as P ON C.idpost = P.id
    WHERE C.postuser = postuser;
    COMMIT;
  END
//

DELIMITER ;

DELIMITER //

DROP PROCEDURE IF EXISTS GetCommentsOfComments //
CREATE PROCEDURE GetCommentsOfComments(
    commentid INT
)
  BEGIN
    SELECT
      CC.idcommentc,
      CC.textcomment,
      CC.idcommentcomment,
      CC.postuser
    FROM CommentComments as CC
        INNER JOIN Comments AS C ON CC.idcommentcomment = C.idcomment
   WHERE C.idcomment = commentid;
    COMMIT;
  END
//

DELIMITER ;

DELIMITER //

--
-- Table Book
--

CREATE TABLE Book (
  `id`       INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `title`    VARCHAR(256)                       NOT NULL,
  `author`   VARCHAR(256)                       NOT NULL,
  `released` DATE                               NOT NULL
)
  ENGINE INNODB
  CHARACTER SET utf8
  COLLATE utf8_swedish_ci;


CREATE TABLE Users (
  `id`          INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `name`        VARCHAR(100)                       NOT NULL,
  `email`       VARCHAR(100)                       NOT NULL UNIQUE,
  `age`         INTEGER(3)                         NOT NULL,
  `password`    VARCHAR(255)                       NOT NULL,
  `points`      INT DEFAULT '0'                            ,
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
