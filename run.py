import urllib
import httplib2
import json

http = httplib2.Http()

url = 'http://rpi.project/index.php'   
body = {'format': 'json', 'id': 1}
headers = {'Content-type': 'application/x-www-form-urlencoded'}
response, content = http.request(url, 'POST', headers=headers, body=urllib.urlencode(body))

content = json.loads(content)

for (key, value) in content.items():
	print key, value

# Do your other work once you get content :D
# content is of the form {id: 1, status1: 0, status0: 1}