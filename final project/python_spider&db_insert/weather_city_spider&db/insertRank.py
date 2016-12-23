from db_conf import *
from helper import *

urank,prank = rank_data()
db = dbop()
for u in urank:
    if(isinstance(u["university_name"],int)):
        db.insert_urank(u["university_name"],u["national_ranking"],"Times")
    else:
        print("no id ",u)

for p in prank:
    if(isinstance(p["university_name"],int)):
        db.insert_prank(p["university_name"],p["subject_name"],p["national_rank"],"Times")
    else:
        print("no id ",p)
