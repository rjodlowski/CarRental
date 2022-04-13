# Car Rental Service
A Svelte-based application for renting cars for multiple users

# Features
User login and verification <br>
Three types of accounts: <br>

Administrator: <br>
Admin can manage different accounts created on the platform, eg. change their type (promote a user to a moderator) <br>

Moderator: <br>
His job is to approve rental requests from all users, he can choose freely from every pending request <br>

User: <br>
User has an option to choose a car from a variety of models and appoint for rental on a specified date <br>
Each car has availbility status and a number of pending requests for its rental <br>
If a car is rent to someone else, another user can't get it at the moment <br>
At "current reservations" tab, user can monitor currently rented cars as well as his requests <br>

MySQL local database containing tables for all cars, users etc. <br>
Each order when expired is moved to the archive table, able to be viewed by a moderator <br>


# Tech Stack
- Svelte
- Tailblocks
- TailwindCSS
- PHP
- MySQL Database
