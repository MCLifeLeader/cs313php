-- Create the Database
CREATE DATABASE Conference;

-- Connect to the datbase just created
\c Conference

-- Create the Event Table. This will track the Conference Highlevel information such as Month / Year
-- IE Name would contain "150th Annual General Conference"
CREATE TABLE public.Event (
	ID SERIAL PRIMARY KEY
	, Name VARCHAR(50) NOT NULL
	, Month SMALLINT NOT NULL
	, Year SMALLINT NOT NULL
);

-- Adding Indexes
CREATE INDEX IX_Event_Name ON public.Event (Name);
CREATE INDEX IX_Event_MonthYear ON public.Event (Month,Year);

-- Each event has various sessions 1 to many
CREATE TABLE public.Sessions (
	ID SERIAL PRIMARY KEY
	, EventId INT NOT NULL REFERENCES public.Event(id)
	, Name VARCHAR(50) NOT NULL
);

-- Adding Index
CREATE INDEX IX_Sessions_Name ON public.Sessions (Name);

-- Each Session has many speakers 1 to many
CREATE TABLE public.Speakers (
	ID SERIAL PRIMARY KEY
	, SessionId INT NOT NULL REFERENCES public.Sessions(id)
	, Name VARCHAR(100) NOT NULL
	, Title VARCHAR(100) NOT NULL
);

-- Adding Index
CREATE INDEX IX_Speakers_Name ON public.Speakers (Name);

-- User's need a table to login and email address for password reset
CREATE TABLE public.Users (
	ID SERIAL PRIMARY KEY
	, UserName VARCHAR(30) NOT NULL UNIQUE
	, Password VARCHAR(100) NOT NULL
	, Email VARCHAR(255) NOT NULL
	, FirstName VARCHAR(50) NOT NULL
	, LastName VARCHAR(50) NOT NULL
);

-- Adding Indexes
-- Unique index to only allow one username in the table
CREATE INDEX UX_Users_UserName ON public.Users (UserName);
CREATE INDEX IX_Users_Name ON public.Users (LastName, FirstName);

-- Notes for talks. For a given speaker you can have many Notes
-- If you add the unique index between userid and speakerid this allows the uers to have one note field
-- for each speaker for that session preventing multiple note pads per the same speaker.
CREATE TABLE public.Notes (
	ID SERIAL PRIMARY KEY
	, UserId INT NOT NULL REFERENCES public.Users(id)
	, SpeakerId INT NOT NULL REFERENCES public.Speakers(id)
	, Title VARCHAR(100) NOT NULL
	, Notes TEXT NULL
);

-- Add Indexes
-- Unique index allows one note pad for each speaker for the same logged in user.
-- CREATE UNIQUE INDEX UX_Notes_UsersSpeakers ON public.Notes (UserId, SpeakerId);
CREATE INDEX IX_Notes_Title ON public.Notes (Title);

-- Adding User
INSERT INTO public.users 
	(username,password,email,firstname,lastname) VALUES 
    ('car03009','password!','car03009@byui.edu','Michael','Carey');
    
INSERT INTO public.users 
	(username,password,email,firstname,lastname) VALUES 
    ('kb7ppb','password!','kb7ppb@hotmail.com','Michael','Carey');

-- Adding Events
INSERT INTO public.event 
    (name,month,year) VALUES
    ('186th Annual General Conference',4,2016);

INSERT INTO public.event 
    (name,month,year) VALUES
    ('186th Semi-Annual General Conference',10,2016);

-- Adding Sessions for Event 1
INSERT INTO public.sessions
    (eventid,name) VALUES
    (1,'General Women''s');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (1,'Saturday Morning');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (1,'Saturday Afternoon');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (1,'Priesthood');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (1,'Sunday Morning');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (1,'Sunday Afternoon');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (2,'General Women''s');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (2,'Saturday Morning');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (2,'Saturday Afternoon');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (2,'Priesthood');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (2,'Sunday Morning');

INSERT INTO public.sessions
    (eventid,name) VALUES
    (2,'Sunday Afternoon');

-- Adding Speakers for Sessions
INSERT INTO public.speakers
    (sessionId,name,title) VALUES
    (1,'Cheryl A. Esplin','He Asks Us to Be His Hands');

INSERT INTO public.speakers
    (sessionId,name,title) VALUES
    (1,'Neill F. Marriott','What Shall We Do?');

INSERT INTO public.speakers
    (sessionId,name,title) VALUES
    (1,'Linda K. Burton','I Was a Stranger');

INSERT INTO public.speakers
    (sessionId,name,title) VALUES
    (1,'Henry B. Eyring','Trust in That Spirit Which Leadeth to Do Good');

-- Adding Notes for speakers
INSERT INTO public.Notes
    (userId,speakerId,title,notes) VALUES
    (1,1,'Note Title 1','Actual Note car03009');

INSERT INTO public.Notes
    (userId,speakerId,title,notes) VALUES
    (1,1,'Note Title 2','Actual Note car03009');

INSERT INTO public.Notes
    (userId,speakerId,title,notes) VALUES
    (1,2,'Note Title 3','Actual Note car03009');

INSERT INTO public.Notes
    (userId,speakerId,title,notes) VALUES
    (2,3,'Note Title 1','Actual Note kb7ppb');

INSERT INTO public.Notes
    (userId,speakerId,title,notes) VALUES
    (2,4,'Note Title 2','Actual Note kb7ppb');

INSERT INTO public.Notes
    (userId,speakerId,title,notes) VALUES
    (2,1,'Note Title 3','Actual Note kb7ppb');

-- Quick Data Test
SELECT et.Name, et.Month, et.Year, sn.Name, sp.Name, sp.Title, nt.Title, nt.Notes, ur.UserName, ur.Email 
	FROM public.event AS et
        JOIN public.sessions AS sn ON et.id=sn.EventId
        JOIN public.speakers AS sp ON sn.Id=sp.sessionId
        JOIN public.Notes AS nt ON sp.Id=nt.speakerId
        JOIN public.Users AS ur ON nt.UserId=ur.Id
;

