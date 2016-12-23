from db_conf import *

try:
    from bs4 import BeautifulSoup
except:
    import BeautifulSoup
import requests

dict = {}

if __name__ == "__main__":
    # get the name of city and its weather info from website
    ini_url = "https://en.wikipedia.org/wiki/List_of_colloquial_names_for_universities_and_colleges_in_the_United_States"
    r = requests.get(ini_url)
    soup = BeautifulSoup(r.content)

    rows = soup.find(id='mw-content-text').find_all('h2')

    for row in rows:
        title = row.find('span').text
        if (len(title) == 1 and title >= 'A' and title <= 'Z'):
            p = row.next_sibling.next_sibling.find_all('li')
            for u in p:
                try:
                    tmp = str(u.text).split(' - ')
                    abbr_tmp,uname = tmp[0],tmp[1]
                except:
                    tmp = str(u.text).split('- ')
                    abbr_tmp,uname = tmp[0],tmp[1]

                uname = uname.split(', ')
                abbr = []
                if ("or" in abbr_tmp):
                    abbr += abbr_tmp.split(' or ')
                else:
                    abbr = [abbr_tmp]

                for n in uname:
                    if (dict.get(n) == None):
                        dict[n] = abbr
                    else:
                        dict[n] += abbr
        else:
            continue

    db = dbop()
    school = db.get_uid_result()

    for uname in dict.keys():
        n = only_alpha_lowercase(uname)
        id = school.get(n)
        if(id != None):
            for abbr in dict[uname]:
                db.insert_abbr(id,abbr)
    db.get_closed()

