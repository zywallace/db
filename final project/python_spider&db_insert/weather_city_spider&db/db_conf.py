# -*- coding:utf-8 -*-

import MySQLdb, sys, re

reload(sys)
sys.setdefaultencoding('utf8')


def only_alpha_lowercase(s):
    return re.sub(r'\W+', '', s).lower()


class dbop:
    con = None
    cur = None

    def get_con(self):
        """
        get connection to local db
        """
        if (self.con == None):
            try:
                self.con = MySQLdb.connect(host="localhost", user="root", passwd="", db="", port=3306,
                                           charset='utf8')
                self.cur = self.con.cursor()
            except:
                raise ValueError("cannot connect to local db")
        else:
            print("db is already connected")

    def get_closed(self):
        """
        close the connection
        """
        if (self.con != None):
            try:
                self.con.close()
                self.cur.close()
            except:
                raise ValueError("cannot cloase connection to local db")
        else:
            print("db is not running")

    def insert_city(self, city_id, cname, state, area, population):
        """
        insert city info into db City
        :param city_id:
        :param cname:
        :param state:
        :param area:
        :param population:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "INSERT INTO City (city_id,cname,state,area,population) VALUES (%s,"'"%s"'","'"%s"'",%s,%s)" % (
            city_id, cname, state, area, population)
        try:
            cur.execute(sql)
            con.commit()
        except:
            print("insert " + cname + " failed")

    def insert_weather(self, city, cname, cmonth, highest_temp, lowest_temp, day_with_precipitation):
        """
        insert weather info into db Weather
        :param city:
        :param cmonth:
        :param highest_temp:
        :param lowest_temp:
        :param day_with_precipitation:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "INSERT INTO Weather (city, cmonth, highest_temp, lowest_temp, day_with_precipitation) VALUES (%s,%s,%s,%s,%s)" % (
            city, cmonth, highest_temp, lowest_temp, day_with_precipitation)
        try:
            cur.execute(sql)
            con.commit()
        except:
            print("insert " + cname + " weather failed")

    def get_city_id(self, cname, state):
        """
        get the city id from db if exits, otherwise return a city id in its state
        :param cname:
        :param state:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "SELECT city_id FROM City WHERE cname = "'"%s"'" AND state = "'"%s"'"" % (cname, state)
        try:
            cur.execute(sql)
            res = cur.fetchall()
            # return the first record
            return str(res[0][0])
        except:
            print("no such city")
            sql = "SELECT city_id FROM City WHERE state = "'"%s"'"" % (state)
            cur.execute(sql)
            res = cur.fetchall()
            # return the first record
            return str(res[0][0])

    def insert_university(self, uid, full_name, website, num_of_undergrad, num_of_grad, location, location_id,
                          living_expense, tuition,
                          male_stu, female_stu, international_stu, average_starting_salary):
        """
        :param uid:
        :param full_name:
        :param website:
        :param num_of_undergrad:
        :param num_of_grad:
        :param location:
        :param living_expense:
        :param male_stu:
        :param female_stu:
        :param international_stu:
        :param average_starting_salary:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "INSERT INTO University (uid,full_name,website,num_of_undergrad,num_of_grad,location,location_id,living_expense,tuition,male_stu,female_stu,international_stu,average_starting_salary) VALUES (%s,"'"%s"'","'"%s"'",%s,%s,"'"%s"'",%s,%s,%s,%s,%s,%s,%s)" % (
            uid, full_name, website, num_of_undergrad, num_of_grad, location, location_id, living_expense, tuition,
            male_stu,
            female_stu, international_stu, average_starting_salary)
        try:
            cur.execute(sql)
            con.commit()
        except:
            print(sql + "insert " + full_name + " failed")

    def insert_abbr(self, uid, uname):
        """
        insert university's abbr into db
        :param uid:
        :param uname:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "INSERT INTO Abbr (uid,uname) VALUES (%s,"'"%s"'")" % (uid, uname)
        try:
            cur.execute(sql)
            con.commit()
        except:
            print("insert " + uname + " weather failed")

    def get_uni_id(self, uname):
        """
        get the city id from db if exits, otherwise return a city id in its state
        :param cname:
        :param state:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "SELECT uid FROM University WHERE full_name = "'"%s"'" " % (uname)
        try:
            cur.execute(sql)
            res = cur.fetchall()
            # return the first record
            return str(res[0][0])
        except:
            print("no such university " + uname)
            return None

    def insert_stat(self, uid, num_of_application, num_of_admission, SAT_math, SAT_reading, SAT_writing, GPA):
        """

        :param uid:
        :param num_of_application:
        :param num_of_admission:
        :param SAT25:
        :param SAT75:
        :param TOEFL:
        :param GPA:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "INSERT INTO AdmissionStats (uid,num_of_application, num_of_admission, SAT_math, SAT_reading, SAT_writing, GPA) VALUES (%s,%s,%s,%s,%s,%s,%s)" % (
            uid, num_of_application, num_of_admission, SAT_math, SAT_reading, SAT_writing, GPA)
        try:
            cur.execute(sql)
            con.commit()
        except:
            print("insert " + str(uid) + " stat failed")
            print(sql)

    def insert_program(self, pid,uid, pname, degree):
        """

        :param uid:
        :param pid:
        :param category_id:
        :param tuition:
        :param degree:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "INSERT INTO Program (pid,uid, pname, degree) VALUES (%s,%s,"'"%s"'","'"%s"'")" % (
            pid,uid, pname, degree)
        try:
            cur.execute(sql)
            con.commit()
        except:
            print("insert " + str(uid) + " stat failed")
            print(sql)

    def insert_urank(self, id, rank, ref):
        """

        :param id:
        :param rank:
        :param ref:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "INSERT INTO URank (uid,rank,ref) VALUES (%s,%s,"'"%s"'")" % (
            id, rank, ref)
        try:
            cur.execute(sql)
            con.commit()
        except:
            print("insert " + str(id) + " rank failed")
            print(sql)

    def insert_prank(self, id, sub, rank, ref):
        """

        :param id:
        :param rank:
        :param ref:
        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "INSERT INTO PRank (uid,subject_name,rank,ref) VALUES (%s,"'"%s"'",%s,"'"%s"'")" % (
            id, sub, rank, ref)
        try:
            cur.execute(sql)
            con.commit()
        except:
            print("insert " + str(id) + sub + " rank failed")
            print(sql)

    def get_uid_result(self):

        """

        :return:
        """
        if (self.cur == None):
            self.get_con()
        con, cur = self.con, self.cur

        sql = "SELECT uid,full_name FROM University"

        try:
            cur.execute(sql)
            res = cur.fetchall()
            school = {}
            for i in res:
                school[only_alpha_lowercase(i[1])] = int(i[0])
            return school
        except:
            print("connection error")
            return None
