# Product Requirements Document (PRD)
# Todo List Application - Native PHP

## 1. Overview

### 1.1 Product Description
The Todo List Application is a simple web application built with Native PHP that allows users to manage their task lists. This application provides complete CRUD (Create, Read, Update, Delete) functionality with data storage in a MySQL database.

### 1.2 Objectives
- Provide a simple interface for todo list management
- Implement efficient CRUD operations
- Data persistence using MySQL database

## 2. Technical Specifications

### 2.1 Technology Stack
- **Backend**: PHP 7.4 or higher
- **Database**: MySQL 5.7 or higher
- **Frontend**: HTML5, CSS3, JavaScript (vanilla), and Bootstrap Latest.

### 2.2 Database Structure

**Table: todos**

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | INT | PRIMARY KEY, AUTO_INCREMENT | Unique todo ID |
| title | VARCHAR(255) | NOT NULL | Todo title |
| description | TEXT | NULL | Detailed todo description |
| status | ENUM('pending', 'in_progress', 'completed') | DEFAULT 'pending' | Todo status |
| priority | ENUM('low', 'medium', 'high') | DEFAULT 'medium' | Todo priority |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Last update time |

## 3. File Structure

```
todo-app/
├── index.php          # Main page (todo list)
├── detail.php         # Todo detail page
├── config.php         # Database configuration
├── functions.php      # Helper functions
├── actions/
│   ├── create.php     # Create todo process
│   ├── update.php     # Update todo process
│   └── delete.php     # Delete todo process
├── assets/
│   └── style.css      # Styling
└── database.sql       # SQL script
```

## 4. Features and Functionality

### 4.1 Index Page (index.php)

**Features:**
- Display all todos in table/card format
- Filter by status (All, Pending, In Progress, Completed)
- Form to add new todo
- Actions: View Detail, Edit, Delete for each todo
- Priority indicator with color coding

**Displayed Information:**
- Todo title
- Status
- Priority
- Created date
- Action buttons (Detail, Edit, Delete)

### 4.2 Detail Page (detail.php)

**Features:**
- Display complete todo information
- Inline edit form to update todo
- Back button to index page
- Confirmation before delete

**Displayed Information:**
- Title
- Complete description
- Status
- Priority
- Created date
- Last updated date

## 5. CRUD Operations

### 5.1 Create (Add Todo)
- **Endpoint**: actions/create.php
- **Method**: POST
- **Parameters**:
  - title (required)
  - description (optional)
  - status (default: 'pending')
  - priority (default: 'medium')
- **Response**: Redirect to index.php with success message

### 5.2 Read (Display Todo)
- **List**: index.php (GET)
- **Detail**: detail.php?id={todo_id} (GET)
- **Response**: HTML page with todo data

### 5.3 Update (Edit Todo)
- **Endpoint**: actions/update.php
- **Method**: POST
- **Parameters**:
  - id (required)
  - title (required)
  - description (optional)
  - status (required)
  - priority (required)
- **Response**: Redirect to detail.php or index.php with success message

### 5.4 Delete (Remove Todo)
- **Endpoint**: actions/delete.php
- **Method**: POST/GET
- **Parameters**:
  - id (required)
- **Response**: Redirect to index.php with success message

## 6. User Interface

### 6.1 Design Guidelines
- **Layout**: Responsive design, mobile-friendly
- **Color Scheme**:
  - Primary: #007bff (Blue)
  - Success: #28a745 (Green)
  - Warning: #ffc107 (Yellow)
  - Danger: #dc3545 (Red)
- **Typography**: Sans-serif, readable font sizes

### 6.2 Status Color Coding
- **Pending**: Gray (#6c757d)
- **In Progress**: Blue (#007bff)
- **Completed**: Green (#28a745)

### 6.3 Priority Color Coding
- **Low**: Green (#28a745)
- **Medium**: Yellow (#ffc107)
- **High**: Red (#dc3545)

## 7. Validation and Error Handling

### 7.1 Input Validation
- Title: Cannot be empty, max 255 characters
- Description: Optional, max 5000 characters
- Status: Must be one of the enum values
- Priority: Must be one of the enum values

### 7.2 Error Handling
- Database connection errors
- Query execution errors
- Invalid todo ID (not found)
- Input validation failed

### 7.3 User Feedback
- Success messages (green alert/notification) using bootstrap
- Error messages (red alert/notification) using bootstrap
- Confirmation before delete (JavaScript confirm) using bootstrap

## 9. Database Script

Complete SQL script available in a separate file that includes:
- Database creation
- Todos table creation
- Sample data (optional)

## 10. Testing Checklist

### 10.1 Functional Testing
- [ ] Create todo successful
- [ ] Read/display todos successful
- [ ] Update todo successful
- [ ] Delete todo successful
- [ ] Filter by status works
- [ ] Todo detail displays complete data

### 10.2 UI Testing
- [ ] Responsive on mobile
- [ ] Responsive on tablet
- [ ] Responsive on desktop
- [ ] Color coding matches specifications

---

## Appendix: Database Schema SQL

```sql
-- Database Creation
CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

-- Table Creation
CREATE TABLE IF NOT EXISTS todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample Data (Optional)
INSERT INTO todos (title, description, status, priority) VALUES
('Learn Native PHP', 'Study basic concepts of PHP and MySQL', 'in_progress', 'high'),
('Setup Database', 'Create database and tables for the application', 'completed', 'high'),
('Implement CRUD', 'Implement Create, Read, Update, Delete functionality', 'pending', 'medium'),
('Test Application', 'Perform functionality testing of the application', 'pending', 'low');
```

---

**Version**: 1.0  
**Last Updated**: September 30, 2025  
**Author**: Development Team