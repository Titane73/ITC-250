/*
 * news-db.sql - updated 8/5/2017
 */

SET foreign_key_checks = 0; #turn off constraints temporarily

#since constraints cause problems, drop tables first, working backward
DROP TABLE IF EXISTS sm17_news_feeds;
DROP TABLE IF EXISTS sm17_news_categories;
  
#all tables must be of type InnoDB to do transactions, foreign key constraints
CREATE TABLE sm17_news_categories(
    NewsCategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(255) DEFAULT '',
    Slug VARCHAR(255) DEFAULT '',
    Description TEXT DEFAULT '',
    DateAdded DATETIME,
    LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (NewsCategoryID)
)ENGINE=INNODB; 

#create some categories
INSERT INTO sm17_news_categories VALUES 
    (NULL, 'Textile Crafts', 'textile-crafts', 'Weaving, Sewing, and Leather', NOW(), NOW()); 
INSERT INTO sm17_news_categories VALUES
    (NULL, 'Gardening', 'gardening', 'Flowers, Vegetables, and Landscaping', NOW(), NOW()); 
INSERT INTO sm17_news_categories
    VALUES (NULL, 'Culinary Arts', 'culinary-arts', 'Baking, Brewing, Grilling: We've got it all!', NOW(), NOW()); 

#foreign key field must match size and type, hence CategoryID is INT UNSIGNED
CREATE TABLE sm17_news_feeds(
    FeedID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    NewsCategoryID INT UNSIGNED DEFAULT 0,
    Name VARCHAR(255) DEFAULT '',
    Slug VARCHAR(255) DEFAULT '',
    Description TEXT DEFAULT '',
    Search VARCHAR(255) DEFAULT '',
    Feed TEXT DEFAULT '',
    DateAdded DATETIME,
    LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (FeedID),
    INDEX NewsCategoryID_index(NewsCategoryID),
    FOREIGN KEY (NewsCategoryID) REFERENCES sm17_news_categories(NewsCategoryID) ON DELETE CASCADE
)ENGINE=INNODB;

INSERT INTO sm17_news_feeds VALUES 
    (NULL,1,'Weaving','weaving','The Best of the Weaving World', 'textile weaving', 'https://news.google.com/news/rss/search/section/q/textile%20weaving/textile%20weaving?hl=en&ned=us', NOW(), NOW());
INSERT INTO sm17_news_feeds VALUES
    (NULL,1,'Sewing','sewing','Sewing, Sewing, Sewing!', 'craft sewing', 'https://news.google.com/news/rss/search/section/q/craft%20sewing/craft%20sewing?hl=en&ned', NOW(), NOW());
INSERT INTO sm17_news_feeds VALUES
    (NULL,1,'Leather Work','leather work','Everything Leather', 'leather work', 'https://news.google.com/news/rss/search/section/q/leather%20work/leather%20work?hl=en&ned=us', NOW(), NOW());
INSERT INTO sm17_news_feeds VALUES
    (NULL,2,'Flowers','flowers’','Blossoms, Blooms, Beauty', 'garden flowers', 'https://news.google.com/news/rss/search/section/q/garden%20flowers/garden%20flowers?hl=en&ned=us', NOW(), NOW());
INSERT INTO sm17_news_feeds VALUES
    (NULL,2,'Vegetables','vegetables','Fresh Fruits Plus Vegetables', 'garden vegetables', 'https://news.google.com/news/rss/search/section/q/garden%20vegetables/garden%20vegetables?hl=en&ned=us', NOW(), NOW());
INSERT INTO sm17_news_feeds VALUES
    (NULL,2,'Landscaping','landscaping','Lovely Landscaping', 'landscaping', 'https://news.google.com/news/rss/search/section/q/landscaping/landscaping?hl=en&ned=us', NOW(), NOW());
INSERT INTO sm17_news_feeds VALUES
    (NULL,3,'Baking','baking','Breads, Buns, Pastries: Everything Baking', 'baking', 'https://news.google.com/news/rss/search/section/q/baking/baking?hl=en&ned=us', NOW(), NOW());
INSERT INTO sm17_news_feeds VALUES
    (NULL,3,'Brewing','brewing','Better Brewing', 'brewing', 'https://news.google.com/news/rss/search/section/q/brewing/brewing?hl=en&ned=us', NOW(), NOW());
INSERT INTO sm17_news_feeds VALUES
    (NULL,3,'Grilling','grilling','Greatest Grilling', 'grilling', 'https://news.google.com/news/rss/search/section/q/grilling/grilling?hl=en&ned=us', NOW(), NOW());

SET foreign_key_checks = 1; #turn foreign key check back on
