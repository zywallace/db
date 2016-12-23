import scrapy
import re

from average_starting_salary.items import AverageStartingSalaryItem


class UniversitySpider(scrapy.spiders.Spider):
    name = "average"
    allowed_domains = ["collegedata.com"]
    start_urls = []

    def start_requests(self):
        pages = []
        for i in range(6, 2200):
            url = 'http://www.collegedata.com/cs/data/college/college_pg06_tmpl.jhtml?schoolId=%s' % i
            page = scrapy.Request(url)
            pages.append(page)
        return pages

    def parse(self, response):

        item = AverageStartingSalaryItem()

        item['university_name'] = response.xpath('//div[@class="cp_left"]/h1/text()').extract()

        average_starting_salary = response.xpath(
            '//th[contains(text(), "Average Starting Salary")] /following-sibling::td/text()').extract()

        try:

            item['average_starting_salary'] = \
                re.sub('[^0-9]', '', str(average_starting_salary[0]).replace(",", "").replace("$", ""))

        except:

            item['average_starting_salary'] = ''

            # remove the coma, dollar sign and the text "Not Reported"

        return item
