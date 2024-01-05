DROP TABLE IF EXISTS mapComments;
CREATE TABLE mapComments (
    id int unsigned NOT NULL auto_increment,
    mapId int unsigned NOT NULL,
    addedDate bigint unsigned NOT NULL,
    author varchar(255) NOT NULL,
    rating tinyint unsigned NULL,
    comment mediumtext NOT NULL,
    screenshotLink text NULL,
    flagCount tinyint unsigned NOT NULL,

    PRIMARY KEY (id),
    CONSTRAINT FK_ratingToMap FOREIGN KEY (mapId) REFERENCES maplist(id)
)