CREATE TABLE scriptures (
    id      SERIAL          NOT NULL,
    book    VARCHAR(256)    NOT NULL,
    chapter INT             NOT NULL,
    verse   INT             NOT NULL,
    content TEXT            NOT NULL,
PRIMARY KEY (id)
);

INSERT INTO scriptures (book, chapter, verse, content) VALUES
('John', 1, 5, 'And the light shineth in darkness; and the darkness comprehended it not.'),
('Doctrine and Covenants', 88, 49, 'The light shineth in darkness, and the darkness comprehendeth it not; nevertheless, the day shall come when you shall comprehend even God, being quickened in him and by him.'),
('Doctrine and Covenants', 93, 28, 'He that keepeth his commandments receiveth truth and light, until he is glorified in truth and knoweth all things.'),
('Mosiah', 16, 9, 'He is the light and the life of the world; yea, a light that is endless, that can never be darkened; yea, and also a life which is endless, that there can be no more death.');

CREATE TABLE topic (
	id		SERIAL			NOT NULL,
	name	VARCHAR(256)	NOT NULL,
PRIMARY KEY (id)
);

INSERT INTO topic (name) VALUES
('Faith'),
('Sacrifice'),
('Charity');

CREATE TABLE scripture_topic (
	id				SERIAL	NOT NULL,
	scripture_id	INT		NOT NULL,
	topic_id		INT		NOT NULL,
PRIMARY KEY (id)
);

ALTER TABLE scripture_topic
  ADD CONSTRAINT "fk_scripture" FOREIGN KEY (scripture_id) REFERENCES scriptures (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

  ALTER TABLE scripture_topic
  ADD CONSTRAINT "fk_topic" FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

