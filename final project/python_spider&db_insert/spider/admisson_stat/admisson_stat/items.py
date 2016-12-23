import scrapy


class AdmissonStatItem(scrapy.Item):

    university_name = scrapy.Field()
    num_of_application = scrapy.Field()
    num_of_admission = scrapy.Field()
    sat_math = scrapy.Field()
    sat_critical_reading = scrapy.Field()
    sat_writing = scrapy.Field()
    toefl = scrapy.Field()
    gpa = scrapy.Field()
