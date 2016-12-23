import scrapy
import re

from university_ranking.items import UniversityRankingItem

class university_ranking(scrapy.spiders.Spider):
    name = "university_ranking"
    allowed_domains = ["https://www.timeshighereducation.com"]
    start_urls = ["https://www.timeshighereducation.com/student/best-universities/best-universities-united-states"]

    def parse(self, response):

        for sel in response.xpath('//td[@class="xl67"]'):

            item = UniversityRankingItem()

            national_ranking = sel.xpath('preceding-sibling::td/text()').extract()

            item['national_ranking'] = int(str(national_ranking[0]).replace("=", ""))

            # convert the ranking into int, in order to satisfy mysql attribute property

            item['university_name'] = re.sub('\W', '', str(sel.xpath('following-sibling::td/a/text()').extract()[0]))

            yield item
