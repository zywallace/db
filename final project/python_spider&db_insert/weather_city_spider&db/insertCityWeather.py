from db_conf import *
from getCityWeather import *

if __name__ == "__main__":
    # get the name of city and its weather info from website
    ini_url = "http://www.usclimatedata.com/climate/united-states/us"
    r = requests.get(ini_url)
    soup = BeautifulSoup(r.content)

    # get the urls of 51 states
    state = soup.find_all('a', class_="province")
    q = []

    for s in state:
        q.append("http://www.usclimatedata.com" + str(s.attrs["href"]))

    # for each state, find cities in it
    i = 1
    j = 1
    for state in q:
        r = requests.get(state)
        soup = BeautifulSoup(r.content)

        res_set = soup.find_all("td", class_="three_column")

        # get the urls of cities
        cities = []
        for city in res_set:
            try:
                cities.append("http://www.usclimatedata.com" + str(city.a.attrs["href"]))
            except:
                continue

        for url in cities:
            # call class city to get info out of website
            city = Weather(url)
            cname, state = city.get_city(), city.get_state()
            high, low, precipitation = city.get_weather()

            # get the demographic info of city from wikipedia
            url = "https://en.wikipedia.org/wiki/" + cname.replace(' ', '_') + ",_" + state
            city = City(url)
            area, pop, id = city.get_area(), city.get_pop(), j
            # insert city info and weather info of this city into local db
            db = dbop()
            db.insert_city(id, cname, state, area, pop)
            for month in range(12):
                db.insert_weather(id, cname, month + 1, high[month], low[month], precipitation[month])
            db.get_closed()
            print(j)
            j += 1
