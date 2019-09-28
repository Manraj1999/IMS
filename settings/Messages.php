<?php

// Database
DEFINE("MSG_ERROR_CONNECT_DB", "Failed to connect to the MySQLi database! Please make sure you've adjusted the settings and try again.");

// Registration
DEFINE("MSG_REGISTER_EMAIL_EXIST", "Email has already been registered. Please try another email.");
DEFINE("MSG_REGISTER_SUCCESS", "User has been registered successfully.");
DEFINE("MSG_REGISTER_FAIL", "There was an error in registering the user.");
DEFINE("MSG_DB_CREATION_FAILED", "We were unable to create your database.");
DEFINE("MSG_TABLE_CREATION_FAILED", "We were unable to create the tables for your database.");
DEFINE("MSG_TABLE_CREATION_INCORRECT_INV_TYPE", "The inventory type selected is incorrect.");

// Login
DEFINE("MSG_LOGIN_SUCCESS", "You've successfully logged in!");
DEFINE("MSG_LOGIN_PASSWORD_VERIFY_FAIL", "The password entered was incorrect. Please try again!");
DEFINE("MSG_LOGIN_NO_RESULT", "You're currently not registered.");