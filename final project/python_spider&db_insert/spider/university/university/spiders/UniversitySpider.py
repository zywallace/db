import scrapy
import re

from university.items import UniversityItem


class UniversitySpider(scrapy.spiders.Spider):
    name = "university"
    allowed_domains = ["collegedata.com"]
    start_urls = []

    def start_requests(self):
        pages = []
        for i in range(6, 2200):
            url = 'http://www.collegedata.com/cs/data/college/college_pg01_tmpl.jhtml?schoolId=%s' % i
            page = scrapy.Request(url)
            pages.append(page)
        return pages

        # we need to customize the urls for crawling, every url for "CollegeData" ends with some ID given by the
        # web designer, so we just pick the first 3000 schools as our samples.
        # (ID 1-5 doesn't represent any university,
        # so we skip 1-5 and then begin from 6)

    def parse(self, response):

        item = UniversityItem()

        # during the following code, since some urls we have constructed might not lead to a profile that really existed,
        # we have to use try/except to deal with these error/empty pages

        item['full_name'] = response.xpath('//div[@class="cp_left"]/h1/text()').extract()

        # On the CollegeData website, the data "full name of the university"
        # are all with tag h1 and their ascendants all have property "class = cp_left"

        item['website'] = response.xpath('//th[contains(text(), "Web Site")] /following-sibling::td/a/@href').extract()

        # On the CollegeData website,
        # the url for a university's website is in form of href and its precedent th contains text "Web Site"

        try:

            num_of_undergrad = response.xpath(
                '//th[contains(text(), "Undergraduate Students")] /following-sibling::td/text()').extract()

            item['num_of_undergrad'] = re.sub('[^0-9]', '', str(num_of_undergrad[0]).replace(",", ""))

        except:

            item['num_of_undergrad'] = ''

        # the data " num_of_undergrad" from our source website includes comma in the number,
        # so we have to remove the comma. -> using replace
        # Also, sometimes the data will say "Not Reported",
        # so we have to make them null -> using re.sub to remove all non numeric characters

        num_of_grad = response.xpath(
            '//th[contains(text(), "Graduate Students")] /following-sibling::td/text()').extract()

        try:

            item['num_of_grad'] = re.sub('[^0-9]', '', str(num_of_grad[0]).replace(",", ""))

            # remove the coma and the text "Not Reported"

        except:

            item['num_of_grad'] = ''

        location = response.xpath('//p[@class="citystate"]/text()').extract()

        try:

            item['location'] = str(location[0]).replace("\n", "").replace("\t", "").replace(" ", "")

        except:

            item['location'] = ''

        # remove some specific characters (including \n, \t, whitespace) from the raw data

        living_expense = response.xpath('//th[@class="sub"]/following-sibling::td/text()').extract()

        try:

            item['living_expense'] = re.sub('[^0-9]', '', str(living_expense[0]).replace(",", "").replace("$", ""))

        except:

            item['living_expense'] = ''

        # remove some specific characters: coma, dollar sign and the text "Not Reported"

        male_stu = response.xpath(
            '//th[contains(text(), "Men")] /following-sibling::td/text()').extract()

        try:

            item['male_stu'] = re.sub('[^0-9]', '', re.split(' ', str(male_stu[0]).replace(",", ""))[0])

        except:

            item['male_stu'] = ''

        # the data "number of male students" consists of number and percentage, we need to remove the percentage part,
        # also, still need to take care of the coma and the text "Not Reported".

        female_stu = response.xpath(
            '//th[contains(text(), "Women")] /following-sibling::td/text()').extract()

        try:

            item['female_stu'] = re.sub('[^0-9]', '', re.split(' ', str(female_stu[0]).replace(",", ""))[0])

        except:

            item['female_stu'] = ''

        # similar to male_stu

        international_stu = response.xpath(
            '//th[contains(text(), "International Students")] /following-sibling::td/text()').extract()

        try:

            international_stu = re.split(' ', str(international_stu[0]).replace("%", ""))[0]

            international_stu = (float(international_stu))/100 * int(item['num_of_undergrad'])

            item['international_stu'] = int(international_stu)

        except: # for situations where there is only empty pages

            item['international_stu'] = ''

        tuition = response.xpath(
            '//div[contains(text(), "Tuition and Fees")]/parent::th/following-sibling::td/text()').extract()

        try:

            item['tuition'] = int(re.sub('[^0-9]', '', str(tuition[0]).replace(",", "").replace("$", "")))

        except:

            # sometimes we might reach empty pages, we need to take care of the errors occurred when we try to manipulate empty values

            item['tuition'] = ''

        return item


        # the data is in form of "10% from 61 countries", so we only keep the percentage part
        # and we need to calculate exact number using the percentage
        # and also need to take care of "Not Reported"

        #request = scrapy.Request(response.url.replace("pg01", "pg06"), callback=self.parse_2)
        #request.meta['item'] = item
        #return request

        # the last item/attribute is on another page, so here we need to call function "callback" to navigate to
        # another page in another parsing function (parse_2), and continue our crawling

    #def parse_2(self, response):

        #item = response.meta['item']

        # inherit the items extracted earlier, ready to continue

        #average_starting_salary = response.xpath(
            #'//th[contains(text(), "Average Starting Salary")] /following-sibling::td/text()').extract()

        #try:

            #item['average_starting_salary'] = \
                #re.sub('[^0-9]', '', str(average_starting_salary[0]).replace(",", "").replace("$", ""))

        #except:

            #item['average_starting_salary'] = ''

            # remove the coma, dollar sign and the text "Not Reported"

        #return item