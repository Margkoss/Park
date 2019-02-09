import urllib.request
import mysql.connector

cnx = mysql.connector.connect(user='root', password='',host='127.0.0.1',database='park')

cursor = cnx.cursor()

query = ("SELECT * FROM admin")

cursor.execute(query)

for x in cursor:
    print(x)

cnx.close()