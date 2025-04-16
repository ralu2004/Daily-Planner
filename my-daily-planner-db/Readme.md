Daily Planner Database

This database is designed to manage tasks, events, users, and related entities, providing robust functionality for organizing, categorizing, and tracking activities. 
The Users table stores individual user information, including name, email, password, and account creation timestamps. 
The Tasks table manages to-do items, tracking details like title, description, due date, priority, and associations with users and categories. Tasks can also have Attachments (stored in the Attachments table) for related files and are further classified using Categories for broad grouping and Tags (via a many-to-many relationship in the Task_Tags table) for flexible labeling. 
The Events table records scheduled events with start and end times, and recurring events are managed using the Recurring_Events table, which defines recurrence patterns. 
Notifications are managed in the Notifications table, linking messages to tasks, events, and users. 
To ensure accountability, the Audit_Logs table tracks user actions on specific records across different tables. The schema also includes indexes for performance optimization (e.g., email in Users) and constraints for maintaining data integrity, such as unique email addresses and valid email formats. 
Views like tasks_current_month and tasks_with_categories provide simplified data retrieval for common queries, such as viewing tasks for the current month or tasks grouped by categories.