# Employee and Visitor Attendance System

Welcome to the Employee and Visitor Attendance System repository! This project is a web-based system designed to manage attendance for both employees and visitors of a company.
# Table of Contents
<ul>
  <li>Features</li>
  <li>Technologies Used</li>
  <li>Usage</li>
  <li>Installation</li>
</ul>

## Features

- **Visitor Registration**: Visitors can enter their details before entering the company premises.
- **Employee Approval**: Admin can approve employee registrations, generating unique IDs for them.
- **Check-In/Check-Out**: Employees can check in and out, with attendance calculated automatically.
- **Attendance Tracking**: Provides a calendar view and analytics for monitoring attendance records.
- **Face Validation**: Utilizes face validation to ensure employees are the ones checking out.
- **Employee Profiles**: Stores employee details, including pictures for identification.
- **Admin Functions**: Admin can view visitors, approve/reject employee registrations, and upload holidays.
- **Calendar Integration**: Displays holidays on the employee calendar for better planning.
- **Password Reset**: Users can request a password reset via email for enhanced security.
- **Analytics**: Provides analytics on attendance records for all employees.

## Technologies Used

<ul>
  <li><b>HTML:</b> The standard markup language for creating web pages. HTML provides the structure and content of a web page.</li>
  <li><b>CSS:</b> Cascading Style Sheets (CSS) is a style sheet language used for describing the presentation of a document written in HTML. CSS enhances the appearance and layout of web pages.</li>
  <li>Bulma UI:A modern CSS framework based on Flexbox for building responsive and mobile-first websites.</li>
  <li>PHP: A server-side scripting language used for web development to create dynamic web pages and applications.</li>
  <li>MySQL:An open-source relational database management system (RDBMS) commonly used with phpMyAdmin for managing databases.</li>
  <li>Wamp Server:A Windows-based web development environment that includes Apache, MySQL, and PHP, allowing for easy setup and configuration of local web servers.</li>
</ul>


## Usage
<p>The Employee and Visitor Attendance System serves as a comprehensive solution for tracking attendance records, managing employee profiles, and monitoring visitor entries to the company premises. It offers features such as visitor registration, employee approval process, attendance tracking, calendar integration, analytics, and more.
</p>

## Installtion
<b>Prerequisites</b>
1. Ensure that you have WampServer installed on your system. You can download it from [WampServer official website](http://www.wampserver.com/en/).
2. Make sure that WampServer is running and Apache and MySQL services are started.

### <b>Installing the Project</b>
1. Download the project files from the repository.
2. Extract the project files to the `www` directory in your WampServer installation folder</b> (typically located at `C:\wamp\www`).
3. Open your web browser and navigate to `http://localhost/phpmyadmin`.
4. Create a new database for the project, if it doesn't exist already.
5. Import the SQL file included with the project into the newly created database.
6. Open a web browser and navigate to `http://localhost/project-folder`</b> (replace `project-folder` with the actual name of the project folder).
7. The project should now be accessible in your web browser.

### <b>Configuration</b>
1. Modify the database connection settings in the project files if necessary to match your MySQL database credentials.
2. Ensure that the project files have the appropriate permissions set for WampServer to access them.
