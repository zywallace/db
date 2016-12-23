import scrapy
import re

from subject_ranking.items import SubjectRankingItem


class SubjectRankingSpider(scrapy.spiders.Spider):
    name = "subject_ranking"
    allowed_domains = ["https://grad-schools.usnews.rankingsandreviews.com/"]
    start_urls = []

    def start_requests(self):
        url_head = "http://grad-schools.usnews.rankingsandreviews.com/best-graduate-schools/"
        url_tail = "/page+1"

        # page+2 and page+3 simply means rank results 26-50, 51-75

        subject_list = ['top-business-schools/mba-rankings', 'top-education-schools/edu-rankings', 'top-engineering-schools/eng-rankings',
                        'top-law-schools/law-rankings', 'top-medical-schools/research-rankings', 'top-medical-schools/primary-care-rankings',
                        'top-nursing-schools/nur-rankings']

        # According to the classification on US News ranking agency, there are six subjects in total.
        # So in order to crawl ranking information for each subject, we have to define our own urls for crawling.
        # Since our project only focuses on US university, so the data is actually prefect for us since
        # what we get on the website is exactly national ranking (top 75 around the US).

        for string in subject_list:
            self.start_urls.append(url_head + string + url_tail)

        for url in self.start_urls:
            yield self.make_requests_from_url(url)

    def parse(self, response):

        for sel in response.xpath('//span[@class="rankscore-bronze cluetip cluetip-stylized"]'):

            item = SubjectRankingItem()

            item['national_rank'] = re.sub('[^0-9]', '', str(sel.xpath('text()').extract()[0]))

            # Get the rank info, and then get rid of other unnecessary characters other than the number.

            university_name = str(sel.xpath('parent::div/parent::td/following-sibling::td/a[@class="school-name"]/text()').extract()[0])

            university_name_1 = university_name.split(' (')[0]

            # university name on this website also includes department information using parentheses, so we get rid of

            # this redundant information, shown following is another way to do this:

            # end_index= university_name.find("(")

            # university_name_1 = university_name[0:end_index-1]

            item["university_name"] = university_name_1.replace('\u2014', '').replace('\u200b', '')

            # get rid of some specific characters

            # the format of university names on this website is different from what we have agreed on in previous project parts,
            # so the several lines above is trying to convert the names into some old format we agree on
            # in order to relate these names with those names already in our databases conveniently

            if 'mba-rankings' in response.url:
                item['subject_name'] = 'business'
            elif 'edu-rankings' in response.url:
                item['subject_name'] = 'education'
            elif 'eng-rankings' in response.url:
                item['subject_name'] = 'engineering'
            elif 'law-rankings' in response.url:
                item['subject_name'] = 'law'
            elif 'research-rankings' in response.url:
                item['subject_name'] = 'medicine research'
            elif 'primary-care-rankings' in response.url:
                item['subject_name'] = 'primary care'
            else:
                item['subject_name'] = 'nursing'

            # Judged by its url, we can determine the subject type that is being processed right now.

            yield item