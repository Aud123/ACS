import pycurl
from StringIO import StringIO

url = "https://fonts.googleapis.com/css?family=Open+Sans"
useragent = "Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US))"

buffer = StringIO()
c = pycurl.Curl()
c.setopt(c.URL, url)
c.setopt(c.USERAGENT, useragent)
c.setopt(c.WRITEDATA, buffer)
c.perform()
c.close()
css = buffer.getvalue()
print(css)

