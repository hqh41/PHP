
---------------------------
---------------------------
---- HELPER FUNCTIONS -----
---------------------------
---------------------------

/**
 * Generate a good enough random string for stub data
 * Do not use for any security purpose
 * @see http://www.simononsoftware.com/random-string-in-postgresql/
 * @param int Size of the desired string
 * @return string A "random" string
 */
CREATE OR REPLACE FUNCTION random_string(int)
RETURNS text
AS $$ 
  SELECT array_to_string(
    ARRAY (
      SELECT substring(
        '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' FROM (random() *26)::int FOR 1)
      FROM generate_series(1, $1) ), '' ) 
$$ LANGUAGE sql;


---------------------------
---------------------------
------- APP SCHEMA --------
---------------------------
---------------------------

--create table test(
--    id serial primary key,
--    whatever varchar not null
--);

DROP TABLE IF EXISTS user1 CASCADE;
CREATE TABLE user1(
    username varchar not null,
    password varchar not null,
    nickname varchar(10) not null,
    sexe varchar(10) default null,
    age integer default null,
    description varchar(100) default NULL,
    photo varchar(100) default NULL,
    email varchar(50) not null,
    is_admin integer NOT NULL DEFAULT 0,
    last_login timestamp (0) without time zone,
    register_date TIMESTAMP (0) WITHOUT TIME ZONE,
    constraint pk_user primary key(username),
    constraint type_isadmin check (is_admin in (1,0)),
    constraint type_sexe check (sexe in ('F','M')),
    constraint range_age check (age>=0 and age<200)
);


DROP TABLE IF EXISTS article CASCADE;
create table article(
  aid serial,
  title varchar(30) not null ,
  content varchar(500) not null ,
  ardate timestamp (0) without time zone,
  tag varchar not null,
  username varchar not null,
  comments integer not null default 0,
  likes integer not null default 0,
  cover_path varchar(250) default null,
  Primary Key (aid),
  FOREIGN KEY (username) REFERENCES user1(username)
);


DROP TABLE IF EXISTS photo CASCADE;
create table photo(
    pid serial,
    aid integer not null,
    path varchar (250) not null,
    constraint pk_photo primary key (pid),
    FOREIGN KEY (aid)  REFERENCES article(aid)
);


DROP TABLE IF EXISTS commentaire CASCADE;
create table commentaire(
    cid serial,
    username varchar not null,
    aid integer not null,
    comcontent varchar not null,
    comdate timestamp (0) without time zone,
    primary key (cid),
    foreign key (username) references user1(username),
    foreign key (aid) references article(aid)
);


DROP TABLE IF EXISTS like_ar CASCADE;
create table like_ar(
    username varchar not null,
    aid integer not null,
    foreign key (username) references user1(username),
    foreign key (aid) references article(aid),
    primary key (username, aid)
);


DROP TABLE IF EXISTS like_com CASCADE;
create table like_com(
    username varchar not null,
    cid integer not null,
    foreign key (username) references user1(username),
    foreign key (cid) references commentaire(cid),
    primary key (username, cid)
);



---------------------------
---------------------------
-------- APP DATA ---------
---------------------------
---------------------------

-- insert 100 random strings of length 20
--insert into test (whatever) 
--    select random_string(20)
--    from generate_series(1, 100)
--;

-- insert into user1 (username, password, nickname, sexe, age, description, photo, email, is_admin, last_login) values ('1','password','nickname','F',18,'i am a girl','photo'
--           ,'luochunmei1109@gmail.com',0, '2017-01-01 04:05:06');
           
-- Admin account
INSERT INTO user1 (username, password, nickname, email, is_admin, register_date)
    VALUES ('admin', '$2y$10$46TCTBBb/YPY2XQkc.i0v.tEp3T.XKGrcx3k2wLl7lH5AZz.jFezO', 'admin', 'wumengsi@hotmail.com', 1, '2017-04-21 15:30:59');

--insert into article (aid, title, content, ardate, tag, username) values (1,'first','i am the first','2017-01-01 04:05:06'
--                            ,'i am tag','1');
                            
--insert into photo(pid, aid, path) values (1, 1,'photo1');

--insert into commentaire (cid, username, aid, comcontent,comdate) values (1, '1', 1, 'content1','2017-01-10 17:03:03');

--insert into like_ar(username, aid) values ('1',1);

--insert into like_com(username, cid) values ('1',1);