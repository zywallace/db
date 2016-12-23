
# This py. file is used to define all the items (attributes) we want to extract in advance.

import scrapy


class ProgramItem(scrapy.Item):

    university_name = scrapy.Field()
    undergrad_program = scrapy.Field()
    master_program = scrapy.Field()
    doctoral_program = scrapy.Field()
    tuition = scrapy.Field()


