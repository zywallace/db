import scrapy
import re

from admisson_stat.items import AdmissonStatItem


class AdmissionSpider(scrapy.spiders.Spider):
    name = "admission_stat"
    allowed_domains = ["http://www.collegedata.com"]
    start_urls = []

    def start_requests(self):
        pages = []
        for i in range(6, 2200):
            url = 'http://www.collegedata.com/cs/data/college/college_pg02_tmpl.jhtml?schoolId=%s' % i
            page = scrapy.Request(url)
            pages.append(page)
        return pages

        # we need to customize the urls for crawling, every url for "CollegeData" ends with some ID given by the
        # web designer, so we just pick the first 2200 schools as our samples. (websites after 2000 are just empty websites)
        # (ID 1-5 doesn't represent any university,
        # so we skip 1-5 and then begin from 6)

    def parse(self, response):

        item = AdmissonStatItem()

        item['university_name'] = response.xpath('//div[@class="cp_left"]/h1/text()').extract()

        if len(item['university_name']) == 0:

            item['university_name'] = "null"

        # now we extract application numbers.
        # in this py. file, we use "try/except" to take care of "Not Reported" situations and also empty page situations

        try:

            application_info = response.xpath('//th[contains(text(), "Overall Admission Rate")] /following-sibling::td/text()').extract()

            # application info on the website is in form of "72% of 9,367 applicants were admitted",
            # so we need to extract accordingly.

            application_info = str(application_info).replace(" ", "").replace("%", "").replace(",", "")

            admission_rate = float(re.sub('[^0-9]', '', re.split('of', str(application_info))[0]))/100

            num_of_applications = re.split('app', re.split('of', str(application_info))[1])[0]

            item['num_of_application'] = int(num_of_applications)

        except:

            item['num_of_application'] = 'null'

        # now we extract numbers of applications admitted

        try:

            application_info = response.xpath(
                '//th[contains(text(), "Overall Admission Rate")] /following-sibling::td/text()').extract()

            # application info on the website is in form of "72% of 9,367 applicants were admitted",
            # so we need to extract accordingly.

            application_info = str(application_info).replace(" ", "").replace("%", "").replace(",", "")

            admission_rate = float(re.sub('[^0-9]', '', re.split('of', str(application_info))[0])) / 100

            num_of_applications = int(re.split('app', re.split('of', str(application_info))[1])[0])

            num_of_admission = admission_rate * num_of_applications

            item['num_of_admission'] = int(num_of_admission)

        except:

            item['num_of_admission'] = 'null'

        # now we extract average SAT scores required

        try:
            sat_math = response.xpath(
                '//th[contains(text(), "SAT Math")] /following-sibling::td/text()').extract()

            # the data on the website also includes some useless characters, we need to remove them

            sat_math_1 = re.split(' ', str(sat_math))[0]

            if "-" in sat_math_1: # required scores in form of range
                item['sat_math'] = int((int(re.sub('[^0-9]', '', re.split('-', sat_math_1)[0]))+int(re.split('-', sat_math_1)[1]))/2)

            else: # required scores in form of average score
                item['sat_math'] = re.sub('[^0-9]', '', sat_math_1)

            if len(item['sat_math']) == 0:
                item['sat_math'] = 'null'

        except:

            item['sat_math'] = 'null'

        try:
            sat_critical_reading = response.xpath(
                '//th[contains(text(), "SAT Critical Reading")] /following-sibling::td/text()').extract()

            # the data on the website also includes some useless characters, we need to remove them

            sat_critical_reading_1 = re.split(' ', str(sat_critical_reading))[0]

            if "-" in sat_critical_reading_1: # required scores in form of range
                item['sat_critical_reading'] = int((int(re.sub('[^0-9]', '', re.split('-', sat_critical_reading_1)[0])) + int(re.split('-', sat_critical_reading_1)[1])) / 2)

            else: # required scores in form of average score
                item['sat_critical_reading'] = re.sub('[^0-9]', '', sat_critical_reading_1)

            if len(item['sat_critical_reading']) == 0:
                item['sat_critical_reading'] = 'null'

        except:

            item['sat_critical_reading'] = 'null'

        try:
            sat_writing = response.xpath(
                '//th[contains(text(), "SAT Writing")] /following-sibling::td/text()').extract()

            # the data on the website also includes some useless characters, we need to remove them

            sat_writing_1 = re.split(' ', str(sat_writing))[0]

            if "-" in sat_writing_1: # required scores in form of range
                item['sat_writing'] = int((int(re.sub('[^0-9]', '', re.split('-', sat_writing_1)[0])) + int(re.split('-', sat_writing_1)[1])) / 2)

            else: # required scores in form of average score
                item['sat_writing'] = re.sub('[^0-9]', '', sat_writing_1)

            if len(item['sat_writing']) == 0:
                item['sat_writing'] = 'null'

        except:

            item['sat_writing'] = 'null'

        # since toefl scores are on other websites other than CollegeData, so we skip this item and make it null

        # now we extract average GPA required

        try:
            gpa = response.xpath(
                '//th[contains(text(), "Average GPA")] /following-sibling::td/text()').extract()
            item['gpa'] = float(gpa[0])

        except:
            item['gpa'] = 'null'


        return item
