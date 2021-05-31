DROP TABLE IF EXISTS maplist;
CREATE TABLE maplist (
	id	int unsigned NOT NULL auto_increment,
	addedDate	bigint unsigned NOT NULL,
	name	varchar(255) NOT NULL,
	author	varchar(255) NOT NULL,
	difficulty	varchar(255) NOT NULL,
	length	varchar(255) NOT NULL,
	shortDescription	text NOT NULL,
	longDescription	mediumtext NOT NULL,
	imageURL	text NOT NULL,
	minecraftVersion	varchar(255) NOT NULL,
	downloadCount	int unsigned NOT NULL,
	series	varchar(255) NOT NULL,
	objectives tinyint unsigned NOT NULL,
	bonusObjectives tinyint unsigned NOT NULL,
	mapType	varchar(255) NOT NULL,
	downloadLink text NOT NULL,
	published int NOT NULL,

	PRIMARY KEY	(id)
);
