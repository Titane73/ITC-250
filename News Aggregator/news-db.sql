/*
  newsdb.sql - updated 7/27/2017
*/

SET foreign_key_checks = 0; #turn off constraints temporarily

#since constraints cause problems, drop tables first, working backward
DROP TABLE IF EXISTS news_feeds;
DROP TABLE IF EXISTS news_categories;
  
#all tables must be of type InnoDB to do transactions, foreign key constraints
CREATE TABLE news_categories(
CategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
Name VARCHAR(255) DEFAULT '',
Slug VARCHAR(255) DEFAULT '',
Description TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (CategoryID)
)ENGINE=INNODB; 

#create some categories
INSERT INTO news_categories VALUES (NULL, 'Textile Crafts', 'textile-crafts', 'Description of Textile Crafts category', NOW(), NOW()); 
INSERT INTO news_categories VALUES (NULL, 'Gardening', 'gardening', 'Description of Gardening category', NOW(), NOW()); 
INSERT INTO news_categories VALUES (NULL, 'Landscaping', 'landscaping', 'Description of Landscaping category', NOW(), NOW()); 

#foreign key field must match size and type, hence CategoryID is INT UNSIGNED
CREATE TABLE news_feeds(
FeedID INT UNSIGNED NOT NULL AUTO_INCREMENT,
CategoryID INT UNSIGNED DEFAULT 0,
Name VARCHAR(255) DEFAULT '',
Slug VARCHAR(255) DEFAULT '',
Description TEXT DEFAULT '',
Search VARCHAR(255) DEFAULT '',
Feed TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (FeedID),
INDEX CategoryID_index(CategoryID),
FOREIGN KEY (CategoryID) REFERENCES news_categories(CategoryID) ON DELETE CASCADE
)ENGINE=INNODB;

INSERT INTO news_feeds VALUES (NULL,1,'Weaving','weaving','Description of Weaving feeds', 'textile weaving', 'https://news.google.com/news/rss/search/section/q/textile%20weaving/textile%20weaving?hl=en&ned=us', NOW(), NOW());
INSERT INTO news_feeds VALUES (NULL,1,'Sewing','sewing','Description of Sewing feeds', 'craft sewing', 'https://news.google.com/news/rss/search/section/q/craft%20sewing/craft%20sewing?hl=en&ned', NOW(), NOW());
INSERT INTO news_feeds VALUES (NULL,1,'Leather Work','leather work','Description of Leather Work feeds', 'leather work', 'https://news.google.com/news/rss/search/section/q/leather%20work/leather%20work?hl=en&ned=us', NOW(), NOW());
INSERT INTO news_feeds VALUES (NULL,2,'Flowers','flowers’','Description of Flowers feeds', 'garden flowers', 'https://news.google.com/news/rss/search/section/q/garden%20flowers/garden%20flowers?hl=en&ned=us', NOW(), NOW());
INSERT INTO news_feeds VALUES (NULL,2,'Vegetables','vegetables','Description of Vegetables feeds', 'garden vegetables', 'https://news.google.com/news/rss/search/section/q/garden%20vegetables/garden%20vegetables?hl=en&ned=us', NOW(), NOW());
INSERT INTO news_feeds VALUES (NULL,2,'Landscaping','landscaping','Description of Landscaping feeds', 'landscaping', 'https://news.google.com/news/rss/search/section/q/landscaping/landscaping?hl=en&ned=us', NOW(), NOW());
INSERT INTO news_feeds VALUES (NULL,3,'Baking','baking','Description of Baking feeds', 'baking', 'https://news.google.com/news/rss/search/section/q/baking/baking?hl=en&ned=us', NOW(), NOW());
INSERT INTO news_feeds VALUES (NULL,3,'Brewing','brewing','Description of Brewing feeds', 'brewing', 'https://news.google.com/news/rss/search/section/q/brewing/brewing?hl=en&ned=us', NOW(), NOW());
INSERT INTO news_feeds VALUES (NULL,3,'Grilling','grilling','Description of Grilling feeds', 'grilling', 'https://news.google.com/news/rss/search/section/q/grilling/grilling?hl=en&ned=us', NOW(), NOW());


/*
Add additional tables here

*/
SET foreign_key_checks = 1; #turn foreign key check back on