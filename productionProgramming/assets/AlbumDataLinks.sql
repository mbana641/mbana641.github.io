DROP TABLE album;

CREATE TABLE album (
id int not null primary key auto_increment,
inserttime datetime,
albumtitle varchar(255),
albumartist varchar(255),
albumlength int,
status varchar(255),
albumlink varchar(255)
);

INSERT INTO album VALUES (0, now(), 'Purple Rain', 'Prince', '60', 'A', 'https://open.spotify.com/album/7nXJ5k4XgRj5OLg9m8V3zc?autoplay=true&v=L');
INSERT INTO album VALUES (0, now(), 'Hotel California', 'Eagles', '55', 'A', 'https://open.spotify.com/album/2widuo17g5CEC66IbzveRu');
INSERT INTO album VALUES (0, now(), 'Desperado', 'Eagles', '47', 'A', 'https://open.spotify.com/album/09WBxbis5Sixt01FVMs8UM');
INSERT INTO album VALUES (0, now(), 'Tusk', 'Fleetwood Mac', '35', 'A', 'https://open.spotify.com/album/1d075yQcykHjerQ2BN0ABn');
INSERT INTO album VALUES (0, now(), 'Meat Dress', 'Lady Gaga', '46', 'A', 'https://open.spotify.com/album/2ZUwFxlWo0gwTsvZ6L4Meh');
INSERT INTO album VALUES (0, now(), 'Reign in Blood', 'Slayer', '51', 'A', 'https://open.spotify.com/album/2DumvqHl78bNXuvU9kQfPN');
INSERT INTO album VALUES (0, now(), 'Yeezus', 'Kanye West', '45', 'A', 'https://open.spotify.com/album/7D2NdGvBHIavgLhmcwhluK');
INSERT INTO album VALUES (0, now(), 'Rumors', 'Fleetwood Mac', '39', 'A', 'https://open.spotify.com/playlist/0snhibsp9U3JuLzuDXecey');
INSERT INTO album VALUES (0, now(), 'Con Todo El Mundo', 'Khruanbin', '53', 'A', 'https://open.spotify.com/album/42j41uUwuHZT3bnedq2XtM');
INSERT INTO album VALUES (0, now(), 'Heaven and Earth', 'Kamasi Washington', '59', 'A', 'https://open.spotify.com/album/2aBgwU4zIm1tekGzphKYp8');
