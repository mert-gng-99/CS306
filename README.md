# ✈️ Airline Operations and Booking System

## 📖 Introduction

This project is part of the CS306 course and focuses on designing and implementing a **relational database** for a modern airline. The goal is to provide a centralized system that manages both **flight operations** and **passenger bookings**, ensuring accurate, clean, and easily accessible data.

## 📚 Table of Contents

* [Introduction](#-introduction)
* [Features](#-features)
* [Database Schema](#-database-schema)
* [Installation](#-installation)
* [Usage](#-usage)
* [Configuration](#-configuration)
* [Sample Data](#-sample-data)
* [Troubleshooting](#-troubleshooting)
* [Contributors](#-contributors)
* [License](#-license)

## ✨ Features

* Track multiple **airlines**, **aircraft**, **pilots**, **flights**, and **airports**
* Manage **passenger bookings**, including unique seat assignments
* Enforce **business rules** via constraints:

  * Aircraft and pilot linked to a single airline
  * Flights must have distinct origin and destination airports
  * Seat numbers must be unique per flight
* Support **many-to-many** relationships through junction tables (`Booking`, `Flight_Crew`)
* Includes **sample data** for testing and development

## 🧩 Database Schema

### Core Entities

* **Airport**: Represents an airport with code, name, city, and country
* **Airline**: Manages aircraft and employs pilots
* **Aircraft**: Assigned to flights, includes model and capacity
* **Pilot**: Associated with airlines and assigned to flights via `Flight_Crew`
* **Passenger**: End-user who books flights
* **Flight**: Contains scheduling info, aircraft, and route
* **Booking**: Manages passenger seats on flights
* **Flight_Crew**: Links pilots to flights with their role

### ER & Relational Design

The ER model follows normalized design with appropriate foreign keys and constraints. Relationships include:

* One-to-many: Airline–>Pilots, Airline–>Aircraft
* Many-to-many: Passengers–Bookings–Flights, Pilots–Flight_Crew–Flights
* Each flight must have valid aircraft, pilot(s), and airports assigned.

## ⚙️ Installation

1. Ensure **MySQL** is installed and running.
2. Use the provided SQL script to set up the database:

```bash
mysql -u your_username -p < phase1.sql
```

3. Confirm tables and sample data are loaded.

## 🚀 Usage

* Use SQL queries to:

  * List flights by airline, origin, or date
  * Find booked passengers on a flight
  * Check aircraft availability
  * Track flight crew assignments

Example query:

```sql
SELECT * FROM Booking WHERE flight_number_fk = 'TK001';
```

## 🔧 Configuration

* Default character set: `utf8mb4`
* Time zone set to `+03:00` (Istanbul local time)
* Ensure foreign key checks are enabled after setup

```sql
SET FOREIGN_KEY_CHECKS = 1;
```

## 📦 Sample Data

Includes data for:

* 10 **Airports**
* 10 **Airlines**
* 10 **Aircraft**
* 10 **Pilots**
* 10 **Passengers**
* 10 **Flights**
* 10 **Bookings**
* 10 **Flight Crew** assignments

This allows immediate testing and validation of system logic.

## 🛠️ Troubleshooting

* **Foreign key constraint error**: Ensure tables are created in the correct order.
* **Duplicate entry errors**: Booking seat numbers must be unique per flight.
* **Missing foreign key reference**: Confirm related entities (e.g., airport codes, aircraft IDs) exist before inserting.

## 👥 Contributors

* **Mert Güngör** – 34159 – [mert.gungor2@sabanciuniv.edu](mailto:mert.gungor2@sabanciuniv.edu)
* **Kaan Berk Karabıyık** – 34424

## 📄 License

This project is intended for educational purposes as part of the CS306 Database Systems course at Sabancı University.

---

Would you like to add:

* Visuals like ER diagrams or schema graphs?
* API interface (if any planned)?
* Future expansion plans (e.g., adding pricing, customer feedback, etc.)?

Let me know, and I can update the README accordingly.
