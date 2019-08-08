DROP TABLE survey;

CREATE TABLE survey (
id int not null primary key auto_increment,
submittime datetime,
major varchar(255),
expectedgrade varchar(255),
favetopping varchar(255),
userip varchar(255),
sessionid varchar(255)
);

DROP TABLE album;

CREATE TABLE album (
id int not null primary key auto_increment,
inserttime datetime,
albumtitle varchar(255),
albumartist varchar(255),
albumlength int,
status varchar(255)
);

INSERT INTO album VALUES (0, now(), 'Purple Rain', 'Prince', '60', 'A');
INSERT INTO album VALUES (0, now(), 'Hotel California', 'Eagles', '55', 'A');
INSERT INTO album VALUES (0, now(), 'Desperado', 'Eagles', '47', 'A');
INSERT INTO album VALUES (0, now(), 'Tusk', 'Fleetwood Mac', '35', 'A');
INSERT INTO album VALUES (0, now(), 'Meat Dress', 'Lady Gaga', '46', 'A');
INSERT INTO album VALUES (0, now(), 'Reign in Blood', 'Slayer', '51', 'A');
INSERT INTO album VALUES (0, now(), 'Yeezus', 'Kanye West', '45', 'A');
INSERT INTO album VALUES (0, now(), 'Rumors', 'Fleetwood Mac', '39', 'A');
INSERT INTO album VALUES (0, now(), 'Con Todo El Mundo', 'Khruanbin', '53', 'A');
INSERT INTO album VALUES (0, now(), 'Heaven and Earth', 'Kamasi Washington', '59', 'A');

ALTER TABLE albuminfo;

ADD Link varchar(255);

DELETE FROM albuminfo WHERE albumtitle = 'Ye' AND albumartist = 'Kanye';

SET SQL_SAFE_UPDATES=0;

UPDATE albuminfo SET Link = 'https://www.amazon.com/s?k=prince+purple+rain&ref=nb_sb_noss_1' WHERE albumtitle = 'Purple Rain' AND albumartist = 'Prince';
UPDATE albuminfo SET Link = 'https://www.amazon.com/Hotel-California-40th-Anniversary-Eagles/dp/B076C1NJYH/ref=sr_1_1?keywords=Hotel+California+cd&qid=1556325207&s=gateway&sr=8-1' WHERE albumtitle = 'Hotel California' AND albumartist = 'Eagles';

UPDATE albuminfo SET Link = 'https://www.amazon.com/Ready-For-Anything/dp/B001F3I04Y/ref=sr_1_fkmr2_1?keywords=Mandolin+Things+Chris+Thile+cd&qid=1556325324&s=gateway&sr=8-1-fkmr2' WHERE albumtitle = 'Mandolin Things' AND albumartist = 'Chris Thile';

UPDATE albuminfo SET Link = 'https://www.amazon.com/Born-This-Way-Lady-Gaga/dp/B0051QIGP4/ref=sr_1_1?keywords=lady+gaga&qid=1556325623&s=dmusic&sr=1-1' WHERE albumtitle = 'Meat Dress' AND albumartist = 'Lady Gaga';
UPDATE albuminfo SET Link = 'https://www.amazon.com/Sweetener-Explicit-Ariana-Grande/dp/B07DTL4H87/ref=sr_1_1?keywords=sweetner+ariana&qid=1556326118&s=gateway&sr=8-1' WHERE albumtitle = 'Sweetener' AND albumartist = 'Ariana Grande';

UPDATE albuminfo SET Link = 'https://www.amazon.com/Reign-Blood-Slayer/dp/B0092MJOMW/ref=sr_1_1?keywords=Reign+in+blood&qid=1556325680&s=gateway&sr=8-1' WHERE albumtitle = 'Reign in Blood' AND albumartist = 'Slayer';

UPDATE albuminfo SET Link = 'https://www.amazon.com/Yeezus-Explicit-Kanye-West/dp/B00DF0POXA/ref=sr_1_1?keywords=Yeesus&qid=1556325733&s=gateway&sr=8-1' WHERE albumtitle = 'Yeesus' AND albumartist = 'Kanye West';

UPDATE albuminfo SET Link = 'https://www.amazon.com/Rumours-Fleetwood-Mac/dp/B000002KGT/ref=sr_1_2?keywords=Rumors&qid=1556325804&s=gateway&sr=8-2' WHERE albumtitle = 'Rumors' AND albumartist = 'Fleetwood Mac';

UPDATE albuminfo SET Link = 'https://www.amazon.com/Todo-El-Mundo-Khruangbin/dp/B076HMG25S/ref=sr_1_1?keywords=Con+Todo+El+Mundo&qid=1556325852&s=gateway&sr=8-1' WHERE albumtitle = 'Con Todo El Mundo' AND albumartist = 'Khruanbin';
UPDATE albuminfo SET Link = 'https://www.amazon.com/Heaven-Earth-Kamasi-Washington/dp/B07CBYKNH4/ref=sr_1_fkmrnull_1_sspa?keywords=Heaven+on+Earth+Kamasi&qid=1556325921&s=gateway&sr=8-1-fkmrnull-spons&psc=1' WHERE albumtitle = 'Heaven and Earth' AND albumartist = 'Kamasi Washington';

UPDATE albuminfo SET Link = 'https://www.amazon.com/ye-Explicit-Kanye-West/dp/B07K7WZSQZ/ref=sr_1_1?keywords=Ye&qid=1556325966&s=gateway&sr=8-1' WHERE albumtitle = 'Ye' AND albumartist = 'Kanye West';




