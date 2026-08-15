# CampusPulse Database Design

## Database Name

`campuspulse`

## Tables

### 1. Users

Stores student account information.

| Column | Purpose |
|---|---|
| id | Unique user identifier |
| name | Student's name |
| email | Student's login email |
| password | Securely stored password |
| created_at | Account creation date/time |

### 2. Budgets

Stores the student's budget.

| Column | Purpose |
|---|---|
| id | Unique budget identifier |
| user_id | Identifies the student who owns the budget |
| amount | Budget amount |
| created_at | Budget creation date/time |

### 3. Expenses

Stores individual student expenses.

| Column | Purpose |
|---|---|
| id | Unique expense identifier |
| user_id | Identifies the student who recorded the expense |
| description | Description of the expense |
| amount | Expense amount |
| expense_date | Date of the expense |
| created_at | Record creation date/time |

### 4. Tasks

Stores academic tasks.

| Column | Purpose |
|---|---|
| id | Unique task identifier |
| user_id | Identifies the student who owns the task |
| title | Task title |
| description | Task details |
| due_date | Task deadline |
| priority | Task priority |
| completed | Completion status |

## Relationships

A user can have multiple budgets, expenses and academic tasks.

- `budgets.user_id` → `users.id`
- `expenses.user_id` → `users.id`
- `tasks.user_id` → `users.id`

The `user_id` fields connect each student's data to their account.

## Task Completion

The `completed` field uses:

- `0` = Not completed
- `1` = Completed

This allows CampusPulse to track the progress of academic tasks.