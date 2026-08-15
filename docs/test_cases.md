# CampusPulse Test Cases

## 1. User Registration

**Test:** Register a new student account.

**Expected Result:**  
A new user account is created successfully and the user can log in.

**Actual Result:**  
The account was created successfully.

**Status:** PASS

---

## 2. User Login

**Test:** Log in using a registered email and password.

**Expected Result:**  
The user is authenticated and redirected to the dashboard.

**Actual Result:**  
The user was successfully redirected to the dashboard.

**Status:** PASS

---

## 3. Invalid Login / Access Protection

**Test:** Attempt to access the dashboard after logging out.

**Expected Result:**  
The user should be redirected to the login page.

**Actual Result:**  
The user was redirected to the login page.

**Status:** PASS

---

## 4. Budget Creation

**Test:** Set a student budget of R6,000.

**Expected Result:**  
The budget should be saved and displayed correctly.

**Actual Result:**  
R6,000 was saved and displayed correctly.

**Status:** PASS

---

## 5. Add Expense

**Test:** Add a R250 transport expense.

**Expected Result:**  
The expense should be saved and included in the total spending.

**Actual Result:**  
The R250 transport expense was saved successfully.

**Status:** PASS

---

## 6. Remaining Budget Calculation

**Test:** Check the remaining budget after spending R250 from R6,000.

**Expected Result:**  
The remaining budget should be R5,750.

**Actual Result:**  
The dashboard displayed R5,750 remaining.

**Status:** PASS

---

## 7. Add Academic Task

**Test:** Add a task with a title, description, due date and priority.

**Expected Result:**  
The task should be saved and appear in the user's task list.

**Actual Result:**  
The task was saved and displayed successfully.

**Status:** PASS

---

## 8. Complete Academic Task

**Test:** Mark an incomplete task as completed.

**Expected Result:**  
The task status should change from "Not completed" to "Completed".

**Actual Result:**  
The task changed to "Completed" and the action changed to "Done".

**Status:** PASS

---

## 9. Required Field Validation

**Test:** Attempt to submit a task without entering a required field.

**Expected Result:**  
The system should prevent submission and request the missing information.

**Actual Result:**  
The browser displayed "Please fill out this field."

**Status:** PASS

---

## 10. Database Default Value Bug

**Test:** Add a task after creating the `completed` field.

**Expected Result:**  
A new task should automatically have a completion value of 0.

**Initial Result:**  
The system produced an error because the `completed` field did not have a default value.

**Fix:**  
The `completed` field was changed to use a default value of 0.

**Final Result:**  
Tasks could be added successfully.

**Status:** FIXED / PASS