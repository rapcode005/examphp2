CREATE DATABASE exam2;

CREATE TABLE IF NOT EXISTS user_profile (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user VARCHAR(30) NOT NULL,
password VARCHAR(30) NOT NULL,
userrole varchar(2) not null,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

insert into user_profile(user, password, userrole, reg_date)
values('admin', '12345', 'a', '2020-12-01');

CREATE TABLE IF NOT EXISTS Profile (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
com decimal(8) NOT NULL,
tax decimal(6) not null,
bonus decimal(8) not null,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Payroll (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
profile_id int (6) NOT NULL,
month_name varchar(15) Not Null,
period varchar(15) Not Null,
c_year int(4) Not Null,
no_client int(3) Not Null,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

Create TABLE IF NOT EXISTS client (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
payroll_id INT(6) Not Null,
name varchar(100) Not Null,
com decimal(8) Not Null
);
