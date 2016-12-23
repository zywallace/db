import csv, json, re
from db_conf import *


def abbr2full():
    # form a dict where key is abbr and value is the full name of one state
    states = {}
    # csv is in the same directory as .py
    file_directory = "data/states.csv"
    with open(file_directory, 'rb') as statefile:
        reader = csv.reader(statefile)
        for row in reader:
            states[row[0]] = row[1]
    return states


def add_space(s):
    # add space between capitalized word in city name
    se = []
    begin = 0
    for end in range(1, len(s)):
        if ((s[end] >= 'A' and s[end] <= 'Z')):
            se.append(s[begin:end])
            begin = end
    se.append(s[begin:])
    return ' '.join(se)


def university_data():
    # get university info from json file and verify its data
    # json is in the same directory as .py
    file_directory = "data/University.json"
    json_data = open(file_directory).read()
    data = json.loads(json_data)

    file_directory = "data/Salary.json"
    json_data = open(file_directory).read()
    salary_data = json.loads(json_data)
    s = {}
    for i in salary_data:
        try:
            s[only_alpha_lowercase(str(i["university_name"][0]))] = i["average_starting_salary"]
        except:
            continue
    for u in data:
        num_of_undergrad, num_of_grad, living_expense, tuition, male_stu, female_stu, international_stu \
            = u["num_of_undergrad"], u["num_of_grad"], u["living_expense"], u["tuition"], u["male_stu"], u[
            "female_stu"], u["international_stu"]
        try:
            uname = only_alpha_lowercase(u["full_name"][0])
        except:
            continue
        salary = s.get(uname)
        if (salary != None and salary != ''):
            u["average_starting_salary"] = salary
        else:
            u["average_starting_salary"] = "NULL"

        # verify some col to be int/float
        try:
            num_of_undergrad = int(num_of_undergrad)
        except:
            u["num_of_undergrad"] = "NULL"
        try:
            num_of_grad = int(num_of_grad)
        except:
            u["num_of_grad"] = "NULL"
        try:
            living_expense = float(living_expense)
        except:
            u["living_expense"] = "NULL"
        try:
            male_stu = int(male_stu)
        except:
            u["male_stu"] = "NULL"
        try:
            female_stu = int(female_stu)
        except:
            u["female_stu"] = "NULL"
        try:
            international_stu = int(international_stu)
        except:
            u["international_stu"] = "NULL"
        try:
            tuition = int(tuition)
        except:
            u["tuition"] = "NULL"
        if (uname):
            try:
                u["website"], u["full_name"] = u["website"][0], u["full_name"][0]
            except:
                u["full_name"] = u["full_name"][0]
                u["website"] = "NULL"
    return data


def get_stat():
    school = {}
    # csv is in the same directory as .py
    file_directory = "data/AdmissionStats.json"
    json_data = open(file_directory).read()
    u_data = json.loads(json_data)
    db = dbop()
    school = db.get_uid_result()
    db.get_closed()
    for u in u_data:
        try:
            name = only_alpha_lowercase(u["university_name"][0])
        except:
            continue
        id = school.get(name)
        if (id != None):
            u["university_name"] = int(id)
    return u_data


def myatoi(s):
    end = 0
    for i in range(len(s)):
        if ((s[i] >= '0' and s[i] <= '9') or s[i] == '.' or s[i] == ','):
            end += 1
        else:
            break
    return s[:end]


def rank_data():
    file_directory = "data/Urank.json"
    json_data = open(file_directory).read()
    u_data = json.loads(json_data)
    db = dbop()
    school = db.get_uid_result()
    db.get_closed()
    for u in u_data:
        name = only_alpha_lowercase(u["university_name"])
        id = school.get(name)
        if (id != None):
            u["university_name"] = int(id)

    file_directory = "data/Prank.json"
    json_data = open(file_directory).read()
    p_data = json.loads(json_data)
    for u in p_data:
        name = only_alpha_lowercase(u["university_name"])
        id = school.get(name)
        if (id != None):
            u["university_name"] = int(id)
    return u_data, p_data


def program_data():
    file_directory = "data/Program.json"
    json_data = open(file_directory).read()
    p_data = json.loads(json_data)
    db = dbop()
    school = db.get_uid_result()
    db.get_closed()
    res = []
    i = 1
    for p in p_data:
        try:
            uname = only_alpha_lowercase(p["university_name"][0])
        except:
            continue
        uid = school.get(uname)
        if (uid == None):
            continue
        for u in p["undergrad_program"]:
            tmp = {}
            tmp["uid"] = uid
            tmp["pid"] = i
            tmp["pname"] = u
            tmp["degree"] = "undergrad"
            res.append(tmp)
            i += 1
        for u in p["master_program"]:
            tmp = {}
            tmp["uid"] = uid
            tmp["pid"] = i
            tmp["pname"] = u
            tmp["degree"] = "master"
            res.append(tmp)
            i += 1
        for u in p["doctoral_program"]:
            tmp = {}
            tmp["uid"] = uid
            tmp["pid"] = i
            tmp["pname"] = u
            tmp["degree"] = "phd"
            res.append(tmp)
            i += 1

    return res
