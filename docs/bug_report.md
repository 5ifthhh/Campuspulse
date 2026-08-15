# CampusPulse Bug Report

## Bug 001 - Task Creation Failed

### Description

When attempting to add a new academic task, the system displayed a fatal database error.

### Error

`Field 'completed' doesn't have a default value`

### Cause

The `completed` column in the `tasks` table was created without a default value.

### Impact

Users were unable to create new academic tasks.

### Fix

The `completed` column was configured with a default value of `0`.

A value of `0` represents an incomplete task, while `1` represents a completed task.

### Retest

After applying the fix, a new task was successfully created and displayed as "Not completed".

The task was then successfully marked as "Completed".

### Status

**RESOLVED**