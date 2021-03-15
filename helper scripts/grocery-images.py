import requests
from bs4 import BeautifulSoup
import mysql.connector as mysqlc

# creates database connection
db = mysqlc.connect(
    host="",
    user="",
    password="",
    database=""
    )

# gets the first 100 item names
cursor = db.cursor(buffered=True)
query = ("SELECT name FROM Grocery_raw_data LIMIT 100;")
cursor.execute(query)


# for each item name, get the first result from google images
for i in cursor:
    url = "https://www.google.com/search?q=" + " " + str(i) + "&safe=active&sxsrf=ACYBGNTyWYkdc3rQDOfPTFinpBDT55OP2Q:1575598277416&source=lnms&tbm=isch&sa=X&ved=2ahUKEwjJ9Yj9-J_mAhXiQd8KHaNSALcQ_AUoAnoECAEQBA&biw=1440&bih=700"
    page = requests.get(url).text
    soup = BeautifulSoup(page, "html.parser")

    # grabbing all the image results, but we only take the first one and insert it into the database
    for raw_img in soup.find_all('img'):
        link = raw_img.get('src')
        if "https" in link:
            cursor = db.cursor(buffered=True)
            cursor.execute("INSERT INTO items (image_url) VALUES('%s')" % (link))
            cursor.close()
            break

# close the database connection
db.commit()
db.close()
