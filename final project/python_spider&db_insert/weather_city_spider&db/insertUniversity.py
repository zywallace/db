from getCityWeather import *
from db_conf import *
from helper import *

# pre load json file and states' abbr
data = university_data()
states = abbr2full()
i = 1
num = 0
for u in data:
    # get info from loaded json file
    try:
        uid, full_name, website, num_of_undergrad, num_of_grad, location, living_expense,tuition, male_stu, female_stu, international_stu, average_starting_salary \
        = i, u["full_name"], u["website"], u["num_of_undergrad"], u["num_of_grad"], u["location"], u[
        "living_expense"], u["tuition"],u["male_stu"], u["female_stu"], u["international_stu"], u["average_starting_salary"]
    except:
        print(uid, " error")
        print(u)
        continue
    # find the cname and its state from location info
    de_index = str(location).find(',')
    cname = add_space(location[:de_index])
    # the school is not in 51 states
    try:
        state = states[location[de_index + 1:]]
    except:
        continue
    # insert operation
    db = dbop()
    id = db.get_city_id(cname, state)
    if (full_name != ""):

        db.insert_university(uid, full_name, website, num_of_undergrad, num_of_grad, location, id, living_expense,
                             tuition,male_stu,female_stu, international_stu, average_starting_salary)
    db.get_closed()
    i += 1
