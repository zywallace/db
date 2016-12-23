1. /SQL/final.sql contains all tables' definitions and all data. You may run mysql -u [username] -p [dbname]<[/path-to-file/SQL/final.sql] to import data.
2. modify the conf.php to local db configuration
3. put webinterface to webserver/documents
4. run localhost/search.php or localhost/browse.php
5. /SQL/sample/sampleSQl.sql has several sample query for db
6. python_spider&db_insert folder contains all .py to get the information from the website and insert them into local db (db_conf.py should be modified if want to insert);

#tables
mysql> describe Abbr;
+-------+----------+------+-----+---------+-------+
| Field | Type     | Null | Key | Default | Extra |
+-------+----------+------+-----+---------+-------+
| uid   | int(11)  | NO   | MUL | NULL    |       |
| uname | char(30) | NO   | MUL | NULL    |       |
+-------+----------+------+-----+---------+-------+
2 rows in set (0.00 sec)

mysql> describe City;
+------------+----------+------+-----+---------+-------+
| Field      | Type     | Null | Key | Default | Extra |
+------------+----------+------+-----+---------+-------+
| city_id    | int(11)  | NO   | PRI | NULL    |       |
| cname      | char(50) | NO   |     | NULL    |       |
| state      | char(20) | NO   |     | NULL    |       |
| area       | float    | YES  |     | NULL    |       |
| population | float    | YES  |     | NULL    |       |
+------------+----------+------+-----+---------+-------+
5 rows in set (0.01 sec)

mysql> describe Weather;
+------------------------+---------+------+-----+---------+-------+
| Field                  | Type    | Null | Key | Default | Extra |
+------------------------+---------+------+-----+---------+-------+
| city                   | int(11) | NO   | PRI | NULL    |       |
| cmonth                 | int(11) | NO   | PRI | NULL    |       |
| highest_temp           | float   | YES  |     | NULL    |       |
| lowest_temp            | float   | YES  |     | NULL    |       |
| day_with_precipitation | float   | YES  |     | NULL    |       |
+------------------------+---------+------+-----+---------+-------+
5 rows in set (0.00 sec)

mysql> describe University;
+-------------------------+----------+------+-----+---------+-------+
| Field                   | Type     | Null | Key | Default | Extra |
+-------------------------+----------+------+-----+---------+-------+
| uid                     | int(11)  | NO   | PRI | NULL    |       |
| full_name               | char(50) | NO   | MUL | NULL    |       |
| website                 | char(50) | NO   |     | NULL    |       |
| num_of_undergrad        | int(11)  | YES  |     | NULL    |       |
| num_of_grad             | int(11)  | YES  |     | NULL    |       |
| location                | char(50) | YES  |     | NULL    |       |
| location_id             | int(11)  | YES  | MUL | NULL    |       |
| living_expense          | int(11)  | YES  |     | NULL    |       |
| tuition                 | int(11)  | YES  |     | NULL    |       |
| male_stu                | int(11)  | YES  |     | NULL    |       |
| female_stu              | int(11)  | YES  |     | NULL    |       |
| international_stu       | int(11)  | YES  |     | NULL    |       |
| average_starting_salary | float    | YES  |     | NULL    |       |
+-------------------------+----------+------+-----+---------+-------+
13 rows in set (0.01 sec)

mysql> describe Program;
+--------+-----------+------+-----+---------+-------+
| Field  | Type      | Null | Key | Default | Extra |
+--------+-----------+------+-----+---------+-------+
| pid    | int(11)   | NO   | PRI | NULL    |       |
| uid    | int(11)   | NO   | MUL | NULL    |       |
| pname  | char(150) | YES  |     | NULL    |       |
| degree | char(20)  | YES  |     | NULL    |       |
+--------+-----------+------+-----+---------+-------+
4 rows in set (0.00 sec)

mysql> describe URank;
+-------+----------+------+-----+---------+-------+
| Field | Type     | Null | Key | Default | Extra |
+-------+----------+------+-----+---------+-------+
| uid   | int(11)  | NO   | MUL | NULL    |       |
| rank  | int(11)  | YES  |     | NULL    |       |
| ref   | char(10) | NO   |     | NULL    |       |
+-------+----------+------+-----+---------+-------+
3 rows in set (0.00 sec)

mysql> describe PRank;
+--------------+----------+------+-----+---------+-------+
| Field        | Type     | Null | Key | Default | Extra |
+--------------+----------+------+-----+---------+-------+
| uid          | int(11)  | NO   | MUL | NULL    |       |
| subject_name | char(30) | YES  |     | NULL    |       |
| rank         | int(11)  | YES  |     | NULL    |       |
| ref          | char(10) | NO   |     | NULL    |       |
+--------------+----------+------+-----+---------+-------+
4 rows in set (0.00 sec)

mysql> describe AdmissionStats;
+--------------------+---------+------+-----+---------+-------+
| Field              | Type    | Null | Key | Default | Extra |
+--------------------+---------+------+-----+---------+-------+
| uid                | int(11) | NO   | PRI | NULL    |       |
| num_of_application | int(11) | YES  |     | NULL    |       |
| num_of_admission   | int(11) | YES  |     | NULL    |       |
| SAT_math           | int(11) | YES  |     | NULL    |       |
| SAT_reading        | int(11) | YES  |     | NULL    |       |
| SAT_writing        | int(11) | YES  |     | NULL    |       |
| GPA                | float   | YES  |     | NULL    |       |
+--------------------+---------+------+-----+---------+-------+
7 rows in set (0.00 sec)

#view
mysql> describe uname;
+-------+----------+------+-----+---------+-------+
| Field | Type     | Null | Key | Default | Extra |
+-------+----------+------+-----+---------+-------+
| uname | char(50) | YES  |     | NULL    |       |
| uid   | int(11)  | NO   |     | 0       |       |
+-------+----------+------+-----+---------+-------+
