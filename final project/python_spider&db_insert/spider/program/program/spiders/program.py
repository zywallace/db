import scrapy
import re

from program.items import ProgramItem


class ProgramSpider(scrapy.spiders.Spider):
    name = "program"
    allowed_domains = ["http://www.collegedata.com"]
    start_urls = []

    def start_requests(self):
        pages = []
        for i in range(6, 2200):
            url = 'http://www.collegedata.com/cs/data/college/college_pg04_tmpl.jhtml?schoolId=%s' % i
            page = scrapy.Request(url)
            pages.append(page)
        return pages

        # we need to customize the urls for crawling, every url for "CollegeData" ends with some ID given by the
        # web designer, so we just pick the first 3000 schools as our samples.
        # (ID 1-5 doesn't represent any university,
        # so we skip 1-5 and then begin from 6)

    def parse(self, response):

        item = ProgramItem()

        item['university_name'] = response.xpath('//div[@class="cp_left"]/h1/text()').extract()

        if len(item['university_name']) == 0:
            item['university_name'] = 'null'

        # On the CollegeData website, the data "full name of the university"
        # are all with tag h1 and their ascendants all have property "class = cp_left"

        item['undergrad_program'] = response.xpath(
            '//caption[contains(text(), "Undergraduate Majors")]/following-sibling::tbody//li/text()').extract()

        if len(item['undergrad_program']) == 0:
            item['undergrad_program'] = 'null'

        item['master_program'] = response.xpath(
            '//caption[contains(text(), "Master")]/following-sibling::tbody//li/text()').extract()

        if len(item['master_program']) == 0:
            item['master_program'] = 'null'

        item['doctoral_program'] = response.xpath(
            '//caption[contains(text(), "Doctoral Programs of Study")]/following-sibling::tbody//li/text()').extract()

        if len(item['doctoral_program']) == 0:
            item['doctoral_program'] = 'null'

        return item
