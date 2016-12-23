import re, requests
from helper import *
try:
    from bs4 import BeautifulSoup
except:
    import BeautifulSoup


class Weather:
    soup = None
    url = None

    def __init__(self, url):
        if url != None:
            self.url = url
        else:
            raise ValueError("url is required")

    def parser(self):
        if self.url != None:
            r = requests.get(self.url)
            soup = BeautifulSoup(r.content)
            self.soup = soup

    def get_state(self):
        """
        get state info from website
        :return: str
        """
        if self.soup == None:
            self.parser()
        soup = self.soup
        res_set = soup.find("p", class_="breadcrumbs").find_all("a")
        try:
            return str(res_set[1].string)
        except:
            print("no state name error")
            return None

    def get_city(self):
        """
        get city info from website
        :return: str
        """
        if self.soup == None:
            self.parser()
        soup = self.soup
        res_set = soup.find("p", class_="breadcrumbs").find_all("a")
        try:
            return str(res_set[2].string)
        except:
            print("no city name error")
            return None

    def get_weather(self):
        """
        get average high temperature,low temperature and precipitation from website
        :return: list[12],list[12],list[12]
        """
        if self.soup == None:
            self.parser()
        soup = self.soup
        res = soup.find_all("td", class_="align_right temperature_red")
        high = []
        for m in res:
            if (m.string == "-"):
                high.append("NULL")
            else:
                high.append(str(m.string))

        res = soup.find_all("td", class_="align_right temperature_blue")
        low = []
        for m in res:
            if (m.string == "-"):
                low.append("NULL")
            else:
                low.append(str(m.string))

        res = soup.find_all("td", class_="climate_table_info", text="Days with precipitation:")
        res1, res2 = res[0], res[1]

        precipitation = []
        for m in res1.next_siblings:
            if (m.string == "-"):
                precipitation.append("NULL")
            else:
                precipitation.append(str(m.string))
        for m in res2.next_siblings:
            if (m.string == "-"):
                precipitation.append("NULL")
            else:
                precipitation.append(str(m.string))

        return high, low, precipitation


class City:
    soup = None
    url = None

    def __init__(self, url):
        if url != None:
            self.url = url
            self.parser()
            res = self.soup.find("b", text="Wikipedia does not have an article with this exact name.")
            if (res):
                print("no " + url + " on wikipedia")
        else:
            raise ValueError("url is required")

    def parser(self):
        if self.url != None:
            r = requests.get(self.url)
            soup = BeautifulSoup(r.content)
            self.soup = soup

    def get_id(self):
        """
        get postal id of city to identify one city
        no longer used
        :return: int
        """
        if self.soup == None:
            self.parser()
        soup = self.soup
        try:
            res = soup.find_all("span", class_="postal-code")
            res = str(res[len(res) - 1].string)
            return int(res[:5])
        except:
            print("failed to get postal code from " + self.url)
            return None

    def get_area(self):
        """
        get area info from website
        :return: str
        """
        if self.soup == None:
            self.parser()

        soup = self.soup
        try:
            temp = str(soup.find(class_=re.compile("infobox")).find(
                text='Area').parent.parent.next_sibling.next_sibling.find('td').text)
            res = myatoi(temp).replace(',', '')
            return res if (res != '') else "NULL"
        except:
            print("failed to get area info from " + self.url)
            return "NULL"


    def get_pop(self):
        """
        get population info from website
        :return: str
        """
        if self.soup == None:
            self.parser()
        soup = self.soup
        try:
            temp = str(soup.find(class_=re.compile("infobox")).find(
                text=re.compile('Population')).parent.parent.next_sibling.next_sibling.find('td').text)
            res = myatoi(temp).replace(',','')
            return res if(res != '') else "NULL"
        except:
            print("failed to get population from " + self.url)
            return "NULL"
