#
#
#Script for database initialization so you don't write sql code
#
#
import time
import webbrowser 
import mysql.connector
from mysql.connector import errorcode


#INITIALIZE DATABASE PARAMS
cnx = mysql.connector.connect(user='root', password='',host='127.0.0.1')
databaseName = 'park' 
cursor = cnx.cursor()


#TABLES FOR THE PARK DB
TABLES = {}
TABLES['admin'] = (
    "CREATE TABLE admin ("
    "admin_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,"
    "admin_first VARCHAR(256) NOT NULL,"
    "admin_last VARCHAR(256) NOT NULL,"
    "admin_pwd VARCHAR(256) NOT NULL"
    ");"
)
TABLES['kml_data'] = (
    "CREATE TABLE kml_data ("
    "gid INT(11) NOT NULL PRIMARY KEY,"
    "esye INT(11) NOT NULL,"
    "population INT(11) NOT NULL,"
    "coordinates TEXT NOT NULL,"
    "centroid TEXT NOT NULL,"
    "parkingSpots INT(11) NOT NULL,"
    "distributionCurveNo INT(1) NOT NULL"
    ");"
)
TABLES['distributions']=(
    "CREATE TABLE distributions ("
    "hour INT(2) NOT NULL,"
    "dist1 FLOAT(3,2) NOT NULL,"
    "dist2 FLOAT(3,2) NOT NULL,"
    "dist3  FLOAT(3,2)"
    ");"
)

while True:
    print("Do you want to auto setup your database? (Y/N)")
    readVar = input()
    print()

    if readVar == "Y" or readVar == "y"  :

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
            
            try:
                print("Creating table {}: ".format(table_name),end='')
                cursor.execute(table_description)
            except mysql.connector.Error as err:
                print(err.msg)

            print("Success!")
        
        #Admin table is harcoded in the project
        cursor.execute("INSERT INTO admin (admin_first,admin_last,admin_pwd) VALUES ('Admin','Adminopoulos','$2y$10$M61Vob6ywTKM6WkzPPtaLOXZnSSfHFArZTJPUcVD5PIt1crcwNyoe');")
        cnx.commit()
        print("Admin added\n")

        #Final message
        print("All done! To populate the database upload kml and csv files from admin page in Park!")
        
        webbrowser.open('localhost/Park')
        break
        
    elif readVar == "N" or readVar == "n" :


        print("Okay bro cya")
        break
    else :


        print("Please select from y or n\n")

time.sleep(1.5)
cnx.close()
exit()