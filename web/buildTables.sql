
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

