import scrapy


class UniversityRankingItem(scrapy.Item):
    university_name = scrapy.Field()
    national_ranking = scrapy.Field()
