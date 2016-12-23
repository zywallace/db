from helper import *

data = program_data()
db = dbop()
for p in data:
    db.insert_program(p["pid"],p["uid"],str(p["pname"]),p["degree"])