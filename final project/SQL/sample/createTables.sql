DROP SCHEMA final;
CREATE SCHEMA final;

USE final;

DROP TABLE City;
CREATE TABLE City (
    city_id INT NOT NULL,
    cname CHAR(50) NOT NULL,
    state CHAR(20) NOT NULL,
    area FLOAT,
    population FLOAT,
    PRIMARY KEY (city_id)
);

DROP TABLE Weather;
CREATE TABLE Weather (
    city INT NOT NULL,
    cmonth INT NOT NULL,
    highest_temp FLOAT,
    lowest_temp FLOAT,
    day_with_precipitation Float,
    PRIMARY KEY(city,cmonth),
    FOREIGN KEY (city)
        REFERENCES City (city_id)
);

DROP TABLE University;
CREATE TABLE University (
    uid INT NOT NULL,
    full_name CHAR(50) NOT NULL,
    website CHAR(50) NOT NULL Unique,
    num_of_undergrad INT,
    num_of_grad INT,
    location CHAR(50),
    location_id INT,
    living_expense INT,
    tuition INT,
    /***
    num of male/femal/intl student
    ***/
    male_stu INT,
    female_stu INT,
    international_stu INT,
    average_starting_salary FLOAT,
    PRIMARY KEY (uid),
    FOREIGN KEY (location_id)
        REFERENCES City (city_id)
);

DROP TABLE Abbr;
CREATE TABLE Abbr (
    #colloquial names for universities
    uid INT NOT NULL,
    uname CHAR(30) NOT NULL,
    FOREIGN KEY (uid)
        REFERENCES University (uid)
);

DROP TABLE Program;
CREATE TABLE Program (
    pid INT NOT NULL,
    uid INT NOT NULL,
    pname CHAR(150),
    degree CHAR(20),
    PRIMARY KEY (pid),
    FOREIGN KEY (uid)
        REFERENCES University (uid)
);

DROP TABLE AdmissionStats;
CREATE TABLE AdmissionStats (
    /***
    SAT25,75 are the 25,75 percentile of SAT score
    TOEFL is the minimum requirement
    ***/
    uid INT NOT NULL,
    num_of_application INT,
    num_of_admission INT,
    SAT_math INT,
	SAT_reading INT,
    SAT_writing INT,
    GPA FLOAT,
    PRIMARY KEY (uid),
    FOREIGN KEY (uid)
        REFERENCES University (uid)
);

DROP TABLE URank;
CREATE TABLE URank (
    uid INT NOT NULL,
    rank INT,
    #ref indicates the source of ranking
    ref CHAR(10) NOT NULL,
    FOREIGN KEY (uid)
        REFERENCES University (uid)
);


DROP TABLE PRank;
CREATE TABLE PRank (
    uid INT NOT NULL,
    rank INT,
    subject_name CHAR(50),
    #ref indicates the source of ranking
    ref CHAR(10) NOT NULL,
    FOREIGN KEY (uid)
        REFERENCES University (uid)
)
