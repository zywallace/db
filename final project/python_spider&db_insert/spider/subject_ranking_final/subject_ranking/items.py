import scrapy


class SubjectRankingItem(scrapy.Item):
    national_rank = scrapy.Field()
    university_name = scrapy.Field()
    subject_name = scrapy.Field()
