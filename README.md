# Task 4 – Security Enhancements Documentation

## Overview

The Blog Management System was enhanced with several security features to protect user data and prevent common web vulnerabilities.

## 1. Prepared Statements

Prepared statements were implemented using MySQLi to prevent SQL Injection attacks.

Files Updated:

* login.php
* register.php
* create.php
* edit.php
* delete.php

Benefit:

* User input is treated as data instead of executable SQL code.
* Prevents unauthorized database access.

## 2. Password Hashing

Passwords are not stored in plain text.

Implementation:

* password_hash() is used during registration.
* password_verify() is used during login.

Benefit:

* Protects user passwords even if the database is compromised.

## 3. Server-Side Validation

Validation is performed before processing form data.

Rules Implemented:

* Username must be at least 3 characters.
* Password must be at least 6 characters.
* Post title must be at least 5 characters.
* Post content must be at least 20 characters.

Benefit:

* Prevents invalid data from being stored in the database.

## 4. Client-Side Validation

HTML form validation is used with:

* required
* minlength

Benefit:

* Improves user experience by providing instant feedback.

## 5. User Roles

A role column was added to the users table.

Available Roles:

* Admin
* Editor

Default Role:

* Editor

Benefit:

* Different permissions can be assigned to different users.

## 6. Role-Based Access Control

Admin:

* Create posts
* Edit posts
* Delete posts

Editor:

* Create posts
* Edit posts
* View posts

Benefit:

* Restricts sensitive operations to authorized users only.

## 7. Session Security

PHP sessions are used to protect authenticated pages.

Implementation:

* session_start()
* Session validation before accessing protected pages

Benefit:

* Prevents unauthorized users from accessing secured pages.

## Conclusion

The application is now more secure through:

* SQL Injection Prevention
* Password Encryption
* Input Validation
* Role-Based Access Control
* Session-Based Authentication

These enhancements satisfy the requirements of Task 4: Security Enhancements.
