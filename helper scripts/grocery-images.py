import requests
from bs4 import BeautifulSoup
import mysql.connector as mysqlc

# creates database connection
db = mysqlc.connect(
    host="",
    user="admin",
    password="",
    database=""
    )

# gets the first 100 item names
cursor = db.cursor(buffered=True)
query = ("SELECT distinct(name) FROM Grocery_raw_data LIMIT 3000;")
cursor.execute(query)

counter = 0

# for each item name, get the first result from google images
for i in cursor:
    counter += 1
    name = str(i)
    name = name[2:-3]
    url = "https://www.google.com/search?q=" + name + "&safe=active&sxsrf=ACYBGNTyWYkdc3rQDOfPTFinpBDT55OP2Q:1575598277416&source=lnms&tbm=isch&sa=X&ved=2ahUKEwjJ9Yj9-J_mAhXiQd8KHaNSALcQ_AUoAnoECAEQBA&biw=1440&bih=700"
    page = requests.get(url).text
    soup = BeautifulSoup(page, "html.parser")

    cursor = db.cursor(buffered=True)
    sql = ("INSERT INTO items (item_id,item_name,image_url) VALUES(%s,%s,%s)")

    # grabbing all the image results, but we only take the first one and insert it into the database
    for raw_img in soup.find_all('img'):
        link = raw_img.get('src')
        image_url = ""
        if "https" in link:
            image_url = link
            break

    data = (counter, name, image_url)
    print(counter, "/3000")
    cursor.execute(sql, data)
    cursor.close()

# close the database connection
db.commit()
db.close()
