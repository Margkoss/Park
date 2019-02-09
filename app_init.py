import urllib.request
import mysql.connector
from mysql.connector import errorcode


#INITIALIZE DATABASE PARAMS
cnx = mysql.connector.connect(user='root', password='',host='127.0.0.1')
databaseName = 'park' 

#TABLES FOR THE PARK DB
TABLES = {}
TABLES['admin'] = (
    "CREATE TABLE admin ("
    "admin_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,"
    "admin_first VARCHAR(256) NOT NULL,"
    "admin_last VARCHAR(256) NOT NULL,"
    "admin_pwd VARCHAR(256) NOT NULL"
    ") ENGINE=InnoDB"
)
TABLES['kml_data'] = (
    "gid INT(11) NOT NULL PRIMARY KEY,"
    "esye INT(11) NOT NULL,"
    "population INT(11) NOT NULL,"
    "coordinates TEXT NOT NULL,"
    "centroid TEXT NOT NULL,"
    "parkingSpots INT(11) NOT NULL,"
    "distributionCurveNo INT(1) NOT NULL"
    ") ENGINE=InnoDB"
)
TABLES['distributions']=(
    "hour INT(2) NOT NULL,"
    "dist1 FLOAT(3,2) NOT NULL,"
    "dist2 FLOAT(3,2) NOT NULL,"
    "dist3  FLOAT(3,2)"
    ") ENGINE=InnoDB"
)


cursor = cnx.cursor()
flag=False

while not flag:
    print("Do you want to auto setup your database? (Y/N)")
    x = input()
    print()

    if x == "Y" or x == "y"  :

        print("Starting...")

        #DROP DB IF EXISTS
        cursor.execute(
        "DROP DATABASE IF EXISTS {} ".format(databaseName))

        #Create park db
        try:
            cursor.execute(
            "CREATE DATABASE {} DEFAULT CHARACTER SET 'utf8'".format(databaseName))
        except mysql.connector.Error as err:
            print("Failed creating database: {}".format(err))
            exit(1)
        print("Database created")


        #Use db park
        try:
            cursor.execute("USE {}".format(databaseName))
        except mysql.connector.Error as err:
            print("Database {} does not exists.".format(databaseName))
            exit(1)
        print("Using database park")

        #Create tables
        for table_name in TABLES:
            table_description = TABLES[table_name]
            


        flag=True
    elif x == "N" or x == "n" :


        print("Okay bro cya")
        exit()
    else :


        print("Please select from y or n\n")


cnx.close()