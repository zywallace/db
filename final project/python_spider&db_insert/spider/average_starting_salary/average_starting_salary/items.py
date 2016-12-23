# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# http://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class AverageStartingSalaryItem(scrapy.Item):
    university_name = scrapy.Field()
    average_starting_salary = scrapy.Field()
