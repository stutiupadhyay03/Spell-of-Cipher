# Spell of Cipher

A full-stack web platform built to run a multi-round coding competition at GSFC University. Built entirely by students, this was the first edition of Spell of Cipher — a university-wide technical event combining aptitude testing, language-specific coding challenges, and a build-and-present hackathon round, with prizes worth ₹20,000.

The platform handled everything from participant registration and team formation through competition day dashboards and result management.

---

## What It Does

**For participants:**
- Register individually or as a team
- Set up team profile with leaderboard name and member management
- Receive automated email confirmation on registration and team additions
- Access a personal dashboard showing competition status and countdown timer
- Complete profile setup with customizable avatars

**For organizers:**
- Manage participant records via a MySQL database
- Track team formation status (solo, team member, under process, inactive)
- Send automated transactional emails via PHPMailer (team invites, OTP for password setup, confirmation emails)
- Handle payment requests for registration fees

---

## Competition Format

**Round 1 — Hello World**
General aptitude test covering mental ability, mathematics, computer science general knowledge, and English.

**Round 2 — Runtime Terror**
Language-specific coding challenge — participants select their preferred programming language and face a timed technical test.

**Round 3 — Cipher's Terminal**
Open-ended hackathon round — participants receive a problem statement, build a working solution, and present to an expert judging panel.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML, CSS, Bootstrap 4/5, JavaScript, Font Awesome |
| Backend | PHP 7+ |
| Database | MySQL (via MySQLi) |
| Email | PHPMailer |
| Charts | Google Charts API |
| Hosting | PHP-compatible web server |

---

## Project Structure

```
soc_hosted-2/
├── index.php           # Landing page with competition info, rounds, prizes, sponsors
├── login.php           # Authentication (login / register)
├── dashboard.php       # Participant dashboard with countdown timer and status
├── profile.php         # User profile page
├── profile_setup.php   # Profile setup with avatar selection
├── team_setup.php      # Team creation, member invitation, member removal
├── set_password.php    # Password setup via OTP
├── recovery.php        # Password recovery flow
├── after_reg.php       # Post-registration confirmation page
├── redirect.php        # Session-based routing
├── paymentrequest.php  # Registration fee payment request handling
├── delete.php          # Account/record deletion
├── dbconnect.php       # MySQL database connection
├── e-400.php           # Error page
├── PHPMailer/          # Email library for transactional emails
├── css/                # Custom stylesheets per page
├── js/                 # JavaScript files
├── images/             # Logos, avatars, illustrations
└── soc-docs/           # Competition documentation
```

---

## Setup

**Requirements:** PHP 7+, MySQL, a web server (Apache/Nginx or XAMPP/WAMP locally)

```bash
git clone https://github.com/stutiupadhyay03/Spell-of-Cipher.git
cd Spell-of-Cipher
```

1. Import the database schema into MySQL (create a database named `soc` or update `dbconnect.php` with your credentials)
2. Configure `dbconnect.php` with your MySQL host, username, password, and database name
3. Configure PHPMailer in the relevant PHP files with your SMTP credentials
4. Serve the folder via a local PHP server or deploy to a PHP-compatible host

```bash
# Quick local run
php -S localhost:8000
# Open: http://localhost:8000
```

---

## Key Features Built

- **Session-based authentication** with login status checks on every protected page
- **OTP-based password setup** for new accounts added via team invitation
- **Automated transactional emails** via PHPMailer for registration confirmation, team invitations, and OTP delivery
- **Team management system** supporting solo participants, team leaders, and team members with status tracking
- **Countdown timer** on the dashboard rendered with JavaScript canvas
- **Google Charts integration** for data visualization on the dashboard
- **Responsive design** using Bootstrap with custom CSS per page
- **Payment request flow** for registration fee handling

---

## Context

Built in 2021 as Overall Coordinator and Content Head of Spell of Cipher at GSFC University. Designed the competition format, built the full platform end-to-end, managed participant communications, coordinated with sponsors, and ran the event. This was a first-edition student-organized event — everything from system architecture to event logistics was built from scratch.

---

## Stack

`PHP` · `MySQL` · `PHPMailer` · `Bootstrap` · `JavaScript` · `HTML/CSS` · `Google Charts`
