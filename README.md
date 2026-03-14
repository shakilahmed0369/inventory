# Inventory Manager

A modern inventory and sales management system built with Laravel 12. Designed for small to medium retail businesses, it provides a full-featured admin panel covering product inventory, point-of-sale, customer management, financial reporting, and double-entry accounting journal.

---

## Features

### Product Management
- Full CRUD for products (SKU, name, description, image, pricing)
- Purchase price vs. sell price tracking
- Opening stock and live current stock levels
- Image upload per product
- Stock automatically decremented on every sale
- Guard against deleting products with existing sale records

### Customer Management
- Full CRUD for customers (name, email, phone, address)
- Customer association on sales for receivables tracking

### Point of Sale (Sales)
- Responsive POS-style sale creation interface
- Product grid with search/filter, paginated with images
- Cart with quantity, unit price, and line subtotal
- Discount (fixed amount), VAT rate, and calculated VAT amount
- Paid amount entry with automatic due amount calculation
- Stock availability validation before processing
- Sale detail view with full line-item breakdown and payment status (Paid / Partial / Unpaid)

### Reports
- Date-range filterable sales report
- Aggregate totals: gross, discount, VAT, net payable, paid, and due
- Paginated sale-by-sale breakdown

### Double-Entry Accounting Journal
- Journal entries auto-generated on every sale via `SaleJournalService`
- Accounts: Cash/Receivable (debit), Sales Revenue (credit), VAT Payable (credit)
- Filterable journal entry list with debit/credit totals
- Entry detail view with full line breakdown and sale reference

### Authentication & Profile
- Laravel Breeze authentication (login, register, password reset, email verification)
- Profile editing and account deletion

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.4, Laravel 12 |
| Frontend | Blade, Tailwind CSS |
| Database | MySQL |
| Auth | Laravel Breeze |
| Notifications | PHPFlasher + Notyf |
| Testing | Pest v4, PHPUnit v12 |
| Code Style | Laravel Pint |
| Local Dev | Laravel Herd or Laravel Sail |

---

## Project Structure

```
app/
 Http/
    Controllers/        # DashboardController, ProductController, CustomerController,
                            SaleController, ReportController, JournalEntryController
    Requests/           # Form request validation classes
 Models/                 # User, Product, Customer, Sale, SaleItem,
                             Account, JournalEntry, JournalEntryLine
 Services/
    SaleJournalService.php   # Double-entry journal automation
 View/Components/        # Blade components

resources/views/
 components/admin/       # Reusable admin UI components (button, input, card, label...)
 layouts/                # Admin layout + sidebar partial
 dashboard/              # Dashboard index view
 products/               # Product CRUD views
 customers/              # Customer CRUD views
 sales/                  # Sale list, create, show views
 reports/                # Reports view
 journal-entries/        # Journal entry list and detail views

database/
 migrations/             # All table migrations
 factories/              # Model factories for testing & seeding
 seeders/                # DatabaseSeeder, AccountSeeder, ProductSeeder,
                              CustomerSeeder, SaleSeeder
```

---

## Roadmap

The following capabilities are planned for future development:

### Near-term
- **Purchase orders**  Record supplier purchases and automatically increment stock
- **Supplier management**  Full CRUD for suppliers linked to purchase orders
- **Payment collection**  Record partial payments against outstanding dues and reduce `due_amount`
- **Invoice PDF export**  Generate printable/downloadable invoice PDFs for each sale

### Medium-term
- **Multi-user roles**  Admin, cashier, and viewer roles with policy-based access control
- **Product categories & tags**  Hierarchical category tree for product classification and filtering
- **Barcode scanning**  Barcode/QR lookup support on the POS screen
- **Discount types**  Percentage-based discounts in addition to fixed-amount discounts
- **Expense tracking**  Record operating expenses as journal entries for a complete P&L

### Long-term
- **Full chart of accounts**  Configurable account tree with balance sheet and income statement views
- **Stock transfers & adjustments**  Manual stock adjustment with reason codes and audit trail
- **Multi-warehouse/location**  Track inventory across multiple store locations
- **REST API**  Versioned JSON API for mobile app or third-party integration
- **Analytics dashboard**  Chart-based revenue trends, product performance, and customer lifetime value

---

## Setup Guide

### Requirements

- PHP 8.4 
- Composer 2
- Node.js 18+ and npm
- MySQL 8 (or compatible MariaDB)
- [Laravel Herd](https://herd.laravel.com) (recommended) **or** Docker for Sail

---

### 1. Clone the repository

```bash
git clone <repository-url> inventory-manager
cd inventory-manager
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run database migrations

```bash
php artisan migrate
```

### 5. Seed demo data *(optional but recommended)*

Seeds 20 men's fashion products with images, 25 customers, and 70 realistic sales:

```bash
php artisan db:seed
```

### 6. Link storage for product images

```bash
php artisan storage:link
```

### 7. Install frontend dependencies and build assets

```bash
npm install
npm run build
```

> During active development use `npm run dev` (or `composer run dev` to start all services together) instead of `npm run build`.

### 8. Start the development server

**With Laravel Herd:** The site is served automatically at `https://inventory-manager.test` (matching the directory name you cloned into). No extra commands needed.

**Without Herd:**

```bash
composer run dev
```

This starts the PHP development server, Vite asset watcher, and queue worker concurrently.

---

### Running Tests

```bash
php artisan test --compact
```

To run a specific test file or filter:

```bash
php artisan test --compact --filter=SaleTest
```

---

### Code Style

This project uses Laravel Pint. Run it before committing:

```bash
vendor/bin/pint --dirty
```

---

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
