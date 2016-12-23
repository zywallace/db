
# This py. file is used to define all the items (attributes) we want to extract in advance.

import scrapy


class UniversityItem(scrapy.Item):

    full_name = scrapy.Field()
    website = scrapy.Field()
    num_of_undergrad = scrapy.Field()
    num_of_grad = scrapy.Field()
    location = scrapy.Field()
    living_expense = scrapy.Field()
    male_stu = scrapy.Field()
    female_stu = scrapy.Field()
    international_stu = scrapy.Field()
    tuition = scrapy.Field()
