DROP FUNCTION IF EXISTS strip;
DELIMITER | 
CREATE FUNCTION strip( str CHAR(50) ) RETURNS CHAR(50) 
BEGIN 
  DECLARE i, len SMALLINT DEFAULT 1; 
  DECLARE res CHAR(50) DEFAULT ''; 
  DECLARE c CHAR(1); 
  SET len = CHAR_LENGTH( str ); 
  REPEAT 
    BEGIN 
      SET c = MID( str, i, 1 ); 
      IF c REGEXP '[[:alnum:]]' THEN 
        SET res=CONCAT(res,c); 
      END IF; 
      SET i = i + 1; 
    END; 
  UNTIL i > len END REPEAT; 
  RETURN LCASE(res); 
END | 
DELIMITER ; 
/***
create a table to store the 'pure' full name of schools, 
which is stripped out of non-alphanumeric characters and is lowercase
***/
DROP VIEW IF EXISTS Uname;
CREATE VIEW Uname AS
    SELECT 
        STRIP(full_name) AS uname, uid
    FROM
        University 
    UNION SELECT 
        STRIP(uname), uid
    FROM
        Abbr;
        
CREATE INDEX uname1 ON University(full_name);
CREATE INDEX uname2 ON Abbr(uname);
