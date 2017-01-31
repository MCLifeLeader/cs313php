
CREATE TABLE db_validate (
	ID BIGSERIAL PRIMARY KEY
	, NAME VARCHAR(50) NOT NULL
);

INSERT INTO db_validate (NAME) VALUES ('Database is Live');

-- I'm not going to bother with data normalization for Assignment03
CREATE TABLE public.surveylist (
	ID BIGSERIAL PRIMARY KEY
	, HostId VARCHAR(100) NOT NULL
	, SurveyData VARCHAR(1024) NOT NULL
);

-- WEEK 05
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

