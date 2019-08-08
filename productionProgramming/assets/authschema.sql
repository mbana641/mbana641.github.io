DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS role;
DROP TABLE IF EXISTS user2role;

CREATE TABLE user (
id int not null primary key auto_increment,
username varchar(255),
userpass varchar(255),
email varchar(255),
creationdate datetime,
realname varchar(255),
userstatus varchar(255)
);

CREATE TABLE role (
id int not null primary key auto_increment,
rolename varchar(255)
);

CREATE TABLE user2role (
id int not null primary key auto_increment,
userid int,
roleid int
);

INSERT INTO user 
(username,userpass,email,creationdate,realname,userstatus) VALUES 
('admin@example.com','$2y$10$Ls90CbGknvCcwiJ.lu4LO.X/7FkO.PwPG2AGlzdm50hNCjq3Cx8n2',
'admin@example.com',now(),'Ted Kennedy','A'),
('user@example.com','$2y$10$SWOYmhBAOoR3CApc9t5PT.RWFEOby7cmf525XM1ngYjeogcMdLnYS','user@example.com',now(),'Woodrow Wilson','A');

INSERT INTO role (rolename) VALUES ('admin');
INSERT INTO role (rolename) VALUES ('user');

INSERT INTO user2role (userid,roleid) VALUES (1,1);
INSERT INTO user2role (userid,roleid) VALUES (1,2);
INSERT INTO user2role (userid,roleid) VALUES (2,2);