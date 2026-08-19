# CampusPulse

## Student Budget & Task Manager

CampusPulse is a web application that helps students manage their budget, track expenses and keep up with academic tasks.

## Features

- Student registration and login
- Budget management
- Expense tracking
- Remaining budget calculation
- Academic task management
- Task due dates and priorities
- Mark tasks as completed
- Dashboard overview
- User session protection

## Technologies

- PHP
- MySQL
- HTML
- CSS
- XAMPP
- phpMyAdmin

## Database

The application uses a MySQL database called `campuspulse`.

The database contains four main tables:

- `users`
- `budgets`
- `expenses`
- `tasks`

## Running the Project

1. Install XAMPP.
2. Start Apache and MySQL.
3. Place the CampusPulse folder inside the XAMPP `htdocs` folder.
4. Create the `campuspulse` database in phpMyAdmin.
5. Open the project in a browser using:

`http://localhost/CampusPulse/`

## Project Structure

```text
CampusPulse/
├── css/
│   └── style.css
├── includes/
│   ├── db.php
│   └── header.php
├── docs/
├── dashboard.php
├── budget.php
├── expenses.php
├── expense_history.php
├── tasks.php
├── task_list.php
├── complete_task.php
├── login.php
├── register.php
└── logout.php

## Current Project Status

The main CampusPulse features have been implemented and tested, including user authentication, budget management, expense tracking and academic task management.
