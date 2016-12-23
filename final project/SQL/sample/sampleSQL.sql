/***
school name has 'johns'
***/
SELECT 
    uid AS 'id', location_id, full_name, website, location
FROM
    University
WHERE
    uid IN (SELECT DISTINCT
            uid
        FROM
            Uname
        WHERE
            uname LIKE '%johns%');

/***
simple filter query
rank < 50
***/

SELECT DISTINCT
    University.uid AS 'id',
    location_id,
    full_name,
    website,
    location
FROM
    University
        LEFT JOIN
    URank ON University.uid = URank.uid
        LEFT JOIN
    AdmissionStats ON University.uid = AdmissionStats.uid
        JOIN
    City ON location_id = city_id
        JOIN
    Weather ON city = city_id
WHERE
    rank <= 50 AND rank >= 1;
/***
simple filter query
rank < 50 and city is rainy
***/

SELECT DISTINCT
    University.uid AS 'id',
    location_id,
    full_name,
    website,
    location
FROM
    University
        LEFT JOIN
    URank ON University.uid = URank.uid
        LEFT JOIN
    AdmissionStats ON University.uid = AdmissionStats.uid
        JOIN
    City ON location_id = city_id
        JOIN
    Weather ON city = city_id
WHERE
    rank <= 50 AND rank >= 1
GROUP BY University.uid
HAVING SUM(day_with_precipitation) >= 150;

/***
complex one
search school using filter
rank<100 tuition<=20000
sat:2200
gpa:3.5-3.9
citysize:small medium
rain:dry
temperature:hot
This query has result of two schools!
***/
SELECT DISTINCT
    University.uid AS 'id',
    location_id,
    full_name,
    website,
    location
FROM
    University
        LEFT JOIN
    URank ON University.uid = URank.uid
        LEFT JOIN
    AdmissionStats ON University.uid = AdmissionStats.uid
        JOIN
    City ON location_id = city_id
        JOIN
    Weather ON city = city_id
WHERE
    rank <= 100 AND tuition <= 20000
        AND SAT_math + SAT_reading + SAT_writing <= 2200
        AND gpa <= 3.9
        AND gpa >= 3.5
        AND ((area <= 22 OR population <= 20000)
        OR ((area > 22 AND area <= 400)
        OR (population > 23000
        AND population <= 100000)))
GROUP BY University.uid
HAVING (SUM(day_with_precipitation) <= 50)
    AND (AVG(highest_temp) > 70
    OR AVG(lowest_temp) > 50);
    
/***
combine above query we could have search school name 'riverside' and above criteria
has one school returned
***/
SELECT DISTINCT
    University.uid AS 'id',
    location_id,
    full_name,
    website,
    location
FROM
    University
        LEFT JOIN
    URank ON University.uid = URank.uid
        LEFT JOIN
    AdmissionStats ON University.uid = AdmissionStats.uid
        JOIN
    City ON location_id = city_id
        JOIN
    Weather ON city = city_id
WHERE
    University.uid IN (SELECT DISTINCT
            uid
        FROM
            Uname
        WHERE
            uname LIKE '%riverside%')
        AND rank <= 100
        AND tuition <= 20000
        AND SAT_math + SAT_reading + SAT_writing <= 2200
        AND gpa <= 3.9
        AND gpa >= 3.5
        AND ((area <= 22 OR population <= 20000)
        OR ((area > 22 AND area <= 400)
        OR (population > 23000
        AND population <= 100000)))
GROUP BY University.uid
HAVING (SUM(day_with_precipitation) <= 50)
    AND (AVG(highest_temp) > 70
    OR AVG(lowest_temp) > 50);
    
/***
query for pagination
search school and order by its full_name
return 20th-30th school
***/
SELECT 
    University.uid AS 'id',
    website,
    location,
    location_id,
    full_name
FROM
    University
ORDER BY full_name
LIMIT 20 , 10;
/***
query for acceptance rate
search school and order by the rate
return schools with acceptance rate 
***/
SELECT 
    University.uid AS 'id',
    website,
    full_name,
    location,
    location_id,
    num_of_admission / num_of_application AS 'rate'
FROM
    University,
    AdmissionStats
WHERE
    University.uid = AdmissionStats.uid
        AND num_of_admission / num_of_application IS NOT NULL
ORDER BY num_of_admission / num_of_application;
/***
query for expense
search school and order by expense
return schools with expense
***/
SELECT 
    University.uid AS 'id',
    website,
    full_name,
    location,
    location_id,
    tuition + living_expense AS 'expense'
FROM
    University
WHERE
    tuition IS NOT NULL
        AND living_expense IS NOT NULL
ORDER BY tuition + living_expense DESC;
/***
query for rank
search school and order by rank
return schools with rank
***/
SELECT 
    University.uid AS 'id',
    website,
    full_name,
    location,
    location_id,
    ref,
    rank
FROM
    University,
    URank
WHERE
    University.uid = URank.uid
ORDER BY rank;
/***
query for school detail

***/
SELECT 
    *
FROM
    University,
    Program
WHERE
    University.uid = Program.uid
        AND University.uid = 1338;
SELECT 
    *
FROM
    AdmissionStats
WHERE
    uid = 1338;

/***
search information of city university is located 
***/

SELECT 
    *
FROM
    City.University
WHERE
    city_id = location_id AND uid = 1338;
/***
search information of city weather 
***/
SELECT 
    *
FROM
    City,
    Weather
WHERE
    city_id = city;
