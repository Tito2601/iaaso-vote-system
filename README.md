# iaaso-vote-system
The IAASO Vote System is a secure web platform that enables students to register, vote online, and view results in real time. Designed to improve participation and transparency in IAASO elections, it offers role-based access, vote tracking, and admin control features.

A secure online voting system for IAASO elections.

## Features

- Secure online voting for presidential candidates
- Student authentication system
- Admin panel for managing candidates and viewing results
- Comprehensive activity logging and audit trail
- CSRF protection
- Detailed security monitoring

## Logging Features

### Activity Logging
The system maintains a detailed audit trail of all activities through the `audit_log` table. Each log entry includes:

- `user_id`: ID of the user performing the action
- `user_type`: Type of user (student/admin/system)
- `action`: Type of action performed
- `details`: Detailed description of the action
- `ip_address`: IP address of the user
- `user_agent`: Browser information
- `created_at`: Timestamp of the action

### Types of Logged Activities

#### Student Activities
- Vote page access
- Voting attempts
- Successful votes
- Invalid votes
- Repeated voting attempts

#### Admin Activities
- Login attempts
- Candidate management (add/delete)
- System access

#### Security Events
- CSRF token validation failures
- Unauthorized access attempts
- Invalid student attempts
- System errors

### Log Storage
All logs are stored in the database and are not visible in the admin interface. They can be accessed directly from the database for audit purposes.

## Security Features

### CSRF Protection
The system implements CSRF protection across all form submissions:

1. Each form includes a unique CSRF token
2. Tokens are generated per session and per page load
3. Tokens are validated on form submission
4. Invalid tokens result in rejected requests

### Authentication
- Secure session management
- Password hashing using PHP's password_hash()
- Single admin account limitation
- Student authentication with ID verification

### Data Validation
- Input sanitization
- SQL injection prevention
- XSS protection
- Form validation

## Project Structure
- `index.php` - Landing page
- `register.php` - Student registration
- `login.php` - Student login
- `vote.php` - Voting page
- `results.php` - Public results
- `db.php` - Database connection
- `admin/` - (Optional) Admin management
- `assets/` - CSS and images

## Setup Instructions
1. Import the provided `database.sql` into your MySQL server.
2. Configure your database credentials in `db.php`.
3. Deploy the files to your PHP server (e.g., XAMPP, WAMP, LAMP).
4. Access the system via your browser.

---

For any issues, contact the project maintainer. laurencytitus@gmail.com +255687230856
