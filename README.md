# ✈️ Airline Operations and Booking System

## 📖 Introduction

This project is part of the **CS306 Database Systems** course at Sabancı University. It focuses on designing and implementing a relational database for a modern airline system. The project includes both **flight operations** and **passenger bookings** with a web-based interface.

## 👥 Contributors

| Name | Student ID | Email |
|------|------------|-------|
| **Mert Güngör** | 34159 | mert.gungor2@sabanciuniv.edu |
| **Kaan Berk Karabıyık** | 34424 | - |

---

## 📚 Project Phases

### Phase 1: Database Design
- ER Diagram design
- Relational schema creation
- Table creation with constraints
- Sample data insertion

### Phase 2: Advanced SQL
- Triggers implementation
- Stored procedures
- Complex queries

### Phase 3: Web Integration
- PHP web application
- MySQL integration with MySQLi
- MongoDB integration for support tickets
- User and Admin interfaces

---

## 🗂️ Project Structure

```
CS306/
├── README.md
├── phase1/
│   ├── CS306 Project Phase 1.pdf
│   └── phase1.sql
├── phase2/
│   ├── CS306_GROUP_66_HW2_REPORT.pdf
│   ├── scripts/
│   │   └── triggers/
│   │       ├── trigger1/
│   │       └── trigger2/
│   └── stored_procedures/
│       ├── stored_procedure_1.sql
│       └── stored_procedure_2.sql
└── phase3/
    ├── CS306_GROUP_66_PHASE3_SQLDUMP.sql
    ├── CS306_GROUP_66_PHASE3_REPORT.pdf      (You need to add)
    ├── CS306_GROUP_66_PHASE3_Demo_Video.mp4  (You need to add)
    └── scripts/
        ├── user/
        │   ├── index.php
        │   ├── db_config.php
        │   ├── mongo_config.php
        │   ├── trigger1.php
        │   ├── trigger2.php
        │   ├── procedure1.php
        │   ├── procedure2.php
        │   ├── tickets.php
        │   ├── create_ticket.php
        │   ├── ticket_confirm.php
        │   └── ticket_detail.php
        └── admin/
            ├── index.php
            ├── db_config.php
            ├── mongo_config.php
            └── ticket_detail.php
```

---

## 🧩 Database Schema

### Core Entities

| Table | Description |
|-------|-------------|
| **Airport** | Airport code, name, city, country |
| **Airline** | Airline code, name, hub airport |
| **Passenger** | Passenger info, email, passport |
| **Aircraft** | Aircraft ID, model, capacity, airline |
| **Pilot** | Pilot info, license number, airline |
| **Flight** | Flight number, times, route, aircraft |
| **Booking** | Passenger-flight relationship, seat |
| **Flight_Crew** | Pilot-flight relationship, role |
| **Booking_Log** | Deleted booking logs (for trigger) |

### Entity Relationships

```
Airport ──────┬──────── Airline (hub)
              │
              ├──────── Flight (origin/destination)
              │
Airline ──────┼──────── Aircraft
              │
              └──────── Pilot
              
Flight ───────┼──────── Booking ──────── Passenger
              │
              └──────── Flight_Crew ──── Pilot
```

---

## 🔧 Triggers

### Trigger 1: check_capacity_before_insert
**Purpose:** Prevents overbooking by checking aircraft capacity before inserting a new booking.

```sql
CREATE TRIGGER check_capacity_before_insert
BEFORE INSERT ON Booking
FOR EACH ROW
BEGIN
    -- Check if flight is full
    -- If full, raise error and block insertion
END;
```

**Web Interface:** `trigger1.php`
- Case 1: Try to add a booking
- Case 2: Show current capacity status
- Case 3: Remove test booking

---

### Trigger 2: log_booking_delete
**Purpose:** Automatically logs deleted bookings to `Booking_Log` table for auditing.

```sql
CREATE TRIGGER log_booking_delete
AFTER DELETE ON Booking
FOR EACH ROW
BEGIN
    -- Insert deleted booking info into Booking_Log
END;
```

**Web Interface:** `trigger2.php`
- Case 1: Delete a booking (trigger fires)
- Case 2: View Booking_Log table
- Case 3: Restore test booking

---

## 📋 Stored Procedures

### Procedure 1: GetPassengerManifest
**Purpose:** Returns the passenger list for a specific flight.

```sql
CREATE PROCEDURE GetPassengerManifest(IN flightNo VARCHAR(10))
BEGIN
    SELECT first_name, last_name, seat_number
    FROM Booking JOIN Passenger
    WHERE flight_number_fk = flightNo;
END;
```

**Web Interface:** `procedure1.php`
- Parameter 1: Flight number (e.g., TK001)
- Output: Passenger list with names and seats

---

### Procedure 2: ScheduleFlight
**Purpose:** Creates a new flight with given parameters.

```sql
CREATE PROCEDURE ScheduleFlight(
    IN f_num VARCHAR(10), 
    IN f_dep DATETIME, 
    IN f_arr DATETIME,
    IN f_plane VARCHAR(10)
)
BEGIN
    INSERT INTO Flight VALUES (...);
END;
```

**Web Interface:** `procedure2.php`
- Parameter 1: Flight number
- Parameter 2: Departure time
- Parameter 3: Arrival time
- Parameter 4: Aircraft ID

---

## 🎫 Support Ticket System (MongoDB)

### Document Structure

```json
{
    "username": "john_doe",
    "message": "I need help with my booking",
    "created_at": "2025-12-28 10:30:00",
    "status": true,
    "comments": [
        "user: Please help",
        "admin: We are looking into it"
    ]
}
```

### User Features
- Create new tickets
- View own tickets (filter by username)
- Add comments to tickets

### Admin Features
- View ALL active tickets
- Add admin comments
- Mark tickets as resolved

---

## ⚙️ Installation Guide

### Prerequisites
- XAMPP (Apache + MySQL)
- MongoDB Community Server
- MongoDB Compass
- PHP MongoDB Extension

### Step 1: Setup XAMPP
1. Download and install XAMPP
2. Start Apache and MySQL from Control Panel

### Step 2: Setup MySQL Database
1. Open `http://localhost/phpmyadmin`
2. Create database named `airline_db`
3. Import `CS306_GROUP_66_PHASE3_SQLDUMP.sql`

### Step 3: Setup MongoDB
1. Install MongoDB Community Server
2. Install MongoDB Compass
3. Connect to `mongodb://localhost:27017`
4. Create database `support_tickets`
5. Create collection `tickets`

### Step 4: Install PHP MongoDB Extension
1. Download `php_mongodb.dll` from [PECL](https://pecl.php.net/package/mongodb)
2. Copy to `C:\xampp\php\ext\`
3. Add `extension = mongodb` to `php.ini`
4. Restart Apache

### Step 5: Deploy PHP Files
```bash
# Copy scripts to XAMPP
cp -r phase3/scripts/user C:/xampp/htdocs/user
cp -r phase3/scripts/admin C:/xampp/htdocs/admin
```

### Step 6: Test
- User Interface: `http://localhost/user`
- Admin Interface: `http://localhost/admin`

---

## 🚀 Usage

### User Interface
1. **Homepage** - Links to triggers, procedures, and tickets
2. **Trigger Pages** - Test database triggers with Case buttons
3. **Procedure Pages** - Execute stored procedures with input parameters
4. **Ticket System** - Create and manage support tickets

### Admin Interface
1. **Dashboard** - View all active tickets from all users
2. **Ticket Detail** - Add comments and resolve tickets

---

## 📄 Sample Queries

### Get all passengers on a flight
```sql
CALL GetPassengerManifest('TK001');
```

### Schedule a new flight
```sql
CALL ScheduleFlight('TK999', '2025-12-28 10:00:00', '2025-12-28 14:00:00', 'TC-JNA');
```

### View booking log
```sql
SELECT * FROM Booking_Log ORDER BY deleted_at DESC;
```

---

## 🛠️ Troubleshooting

| Problem | Solution |
|---------|----------|
| MySQL connection error | Check if MySQL is running in XAMPP |
| MongoDB connection error | Check if MongoDB service is running |
| PHP MongoDB extension not found | Verify `php_mongodb.dll` is in ext folder and `php.ini` is updated |
| Foreign key constraint error | Import SQL file in correct order |
| Tickets not showing | Check MongoDB database and collection names |

---

## 📦 Dependencies

- PHP 8.x
- MySQL 8.x
- MongoDB 6.x
- XAMPP
- MongoDB PHP Driver

---

## 📝 License

This project is for educational purposes as part of the CS306 Database Systems course at Sabancı University.

---

## 🔗 References

- [PHP + XAMPP Setup](https://www.youtube.com/watch?v=jLqBiSDNXO0)
- [MongoDB PHP Driver](https://www.mongodb.com/docs/php-library/current/)
- [MySQLi Documentation](https://www.php.net/manual/en/book.mysqli.php)
