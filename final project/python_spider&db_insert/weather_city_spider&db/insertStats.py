from helper import *
data = get_stat()
db = dbop()
for u in data:
    if(isinstance(u["university_name"],int)):
        db.insert_stat(u["university_name"],str(u["num_of_application"]),str(u["num_of_admission"]),str(u["sat_math"]),\
                       str(u["sat_critical_reading"]),str(u["sat_writing"]),str(u["gpa"]))
db.get_closed()