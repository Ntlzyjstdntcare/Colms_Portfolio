Colms_Portfolio
===============

Holds Colm Ginty's apps, all built over the last eight months (as of 06/06/2014).


1) Java implementation of Dijkstra's algorithm for finding the shortest route between two points in a cyclical, 
non-directed graph. Uses HashMaps for the primary data structures. Linear time complexity.

2) AJAX web app which hosts a regularly updating photo stream from Flickr, based on the search term entered by the user. 
Also uses PHP on the server side.

3) Link checking app which takes a URL as a command line argument and outputs a table of host names, and the number of 
broken links at that host, at the given URL. Written in Java.

4) Sample e-commerce site, built using PHP and MySQL. JavaScript is used for most input checking.

5) Mood-logging web app built using PHP and MySQL.

6) Library program

7) Choose Your Own Adventure application, built in Java. Designed to explore the Binary Tree data structure. This was a 
group project involving four individuals. I came up with the original idea, and designed the CYOANode class.



The e-commerce site and the mood-logging app each require a 4-table database. The fields are, respectively:

orders(order_id, quantity, custID, productID, date_added, orders_session), products(id, product_name, price, details, 
category, stock, date_added), shipping_address(id, shipping_address, shipping_address2, city, county, zip_code, country, 
date_added, customerID), users(id, first_name, surname, address, address2, city_town, county_state, postal_code, country, 
telephone, email, date_added, customer_session, username, password, admin, last_log_date)

cbt(id, before_, feel, self_image, supporting_evidence, contradictory_evidence, another_explanation, date_entered), 
thoughts(id, thought, mood, last_log_date), tips(id, tip), users(id, username, last_log_date)
