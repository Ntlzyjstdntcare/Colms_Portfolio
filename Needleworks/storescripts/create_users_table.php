<?php
//This script is run once in order to create our table of users in the database. 


//Connect to database
require"connect_to_mysql.php";

//Create table with our desired columns and parameters
$sqlCommand="CREATE TABLE users (
        id int(11) NOT NULL auto_increment,
		first_name varchar(30),
		surname varchar(30),
		address varchar(64),
		address2 varchar(64),
		city_town varchar(64),
		county_state varchar(64),
		postal_code varchar(64),
		country varchar(40),
		telephone varchar(20),
		email varchar(40),
		date_added date,
		customer_session varchar(64),
		username varbinary(20),
		password varchar(100),
		admin varchar(6),
		last_log_date date,
		PRIMARY KEY (id)
		)";

//If table is created successfully...
if(mysql_query($sqlCommand))
{
    //...return this message to the user
    echo"Your users table has been created successfully!";
} else
{
    //Otherwise, return this error message
    echo"CRITICAL ERROR: users table has not been created.";
}
?>