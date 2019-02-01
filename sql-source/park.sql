/*

------DISCLAIMER------ 

Would never include sql source code in the folder 
that the server serves from it's just for the needs
of the project. We recognize that it is very unsafe :P

*/


--DATABASE CREATION

CREATE DATABASE Park;

--ADMIN TABLE

CREATE TABLE admin (
    admin_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    admin_first VARCHAR(256) NOT NULL,
    admin_last VARCHAR(256) NOT NULL,
    admin_pwd VARCHAR(256) NOT NULL
);

--INSERT THE ONE AND ONLY TEST ADMIN (PASSWORD UNHASHED)

INSERT INTO admin (admin_first,admin_last,admin_pwd) VALUES
('Admin','Adminopoulos','Adminakias123');

--GEO-DATA TABLE

CREATE TABLE kml_data(
	gid INT(11) NOT NULL PRIMARY KEY,
    esye INT(11) NOT NULL,
    population INT(11) NOT NULL,
    coordinates TEXT NOT NULL,
    centroid TEXT NOT NULL,
    parkingSpots INT(11) NOT NULL,
    distributionCurveNo INT(1) NOT NULL
);

--DISTRIBUTION CURVE DATA

CREATE TABLE distributions(
    hour INT(2) NOT NULL,
    dist1 FLOAT(3,2) NOT NULL,
    dist2 FLOAT(3,2) NOT NULL,
    dist3  FLOAT(3,2)
);