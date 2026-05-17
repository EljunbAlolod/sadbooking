# Cloning and Installation Guide

Follow these steps to get the **Boarding Hub** project up and running on your local machine.

## 📋 Prerequisites

Ensure you have the following installed:
- **PHP 8.3** or higher
- **Composer**
- **Node.js & NPM**
- **MySQL** or any supported database engine

---

## 🚀 Quick Setup (Recommended)

If you have all prerequisites installed, you can run the following commands to set up the project automatically:

```bash
# 1. Clone the repository
git clone <repository-url> sadbooking
cd sadbooking

# 2. Run the setup script
composer run setup

# 3. Seed the database (Optional but recommended for testing)
php artisan db:seed
```

---

## 🛠 Manual Installation

If you prefer to run steps manually or need to troubleshoot:

### 1. Clone the Repository
```bash
git clone <repository-url> sadbooking
cd sadbooking
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
Copy the example environment file and generate the application key:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
1. Create a database named `sadbooking` in your local database manager.
2. Update the `DB_*` variables in your `.env` file if necessary.
3. Run migrations and seeders:
```bash
php artisan migrate --seed
```

### 5. Create Storage Link
```bash
php artisan storage:link
```

### 6. Compile Assets
```bash
npm run build
```

---

## 👨‍💻 Development

To start the development server (includes Laravel serve, Vite, and Queue listener):

```bash
composer run dev
```

The application will be available at [http://localhost:8000](http://localhost:8000).

---

## 🔑 Test Credentials

The database seeder creates the following test accounts (all with the password: `password`):

| Role | Email | Password |
| :--- | :--- | :--- |
| **Super Admin** | `superadmin@example.com` | `password` |
| **Landlord** | `landlord@example.com` | `password` |
| **Tenant** | `tenant@example.com` | `password` |

---

## 📖 Related Documentation
- [User Manual](USER_MANUAL.md)
- [Database Schema](DATABASE_SCHEMA.md)
