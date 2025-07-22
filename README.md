# Bedexa

Bedexa is a modern, modular Hotel Management System built with Laravel, Livewire, Blade and Tailwind CSS. Designed from the ground up for small guesthouses and boutique hotels, especially in the Maldives. Bedexa gives you full control over your property without sacrificing flexibility or style. Under the Business Source License 1.1, you’re free to self-host, extend, and customize; after July 23, 2028 the code will automatically relicense under GPL 3.0+.

## 🚀 Overview

Bedexa is an open-source (BSL 1.1 → GPL 3.0+) Hotel PMS (Property Management System) that helps you:

- **Manage rooms & room categories**
- **Create guest registration cards & bookings**
- **Issue booking vouchers & invoices**
- **Accept partial or full payments, in any currency**
- **Run day-end reports, occupancy & revenue summaries**
- **Visualize a drag-and-drop booking calendar**
- **Configure service charges, green tax & regional compliance**
- **Extend via Laravel Actions, Livewire components & APIs**

It’s built for self-hosting-no mandatory SaaS lock-in-and comes with a clear upgrade path to a fully open GPL license in 2028.

## 📦 Features

- **Room & Category CRUD** with configurable rates, bed counts and status (available, occupied, maintenance)
- **Multi-currency support** (base currency + exchange rates)
- **Tax & fee configuration** (service charge, tourism green tax, no-show fees)
- **Guest registration cards** & stay-details tracking
- **Booking vouchers** with check-in/check-out control
- **Invoice generation** (proforma & final) and payment receipts
- **Partial & full payment workflows** with manual adjustments
- **Day-end & periodic reports** (daily, weekly, monthly)
- **Interactive booking calendar** with drag-and-drop room assignments
- **Activity module** (snorkeling, tours, transport add-ons)
- **Extensible via Laravel Actions & Livewire** for custom business logic
- **Clean, responsive UI** powered by Blade + Tailwind CSS

## 🎯 Getting Started

### Requirements

- PHP ≥ 8.1
- Laravel 12+
- MySQL 5.7+ (or PostgreSQL)
- Node.js 16+ (for asset compilation)
- Redis or Memcached (optional, for queue & cache)

### Installation

1. **Clone the repo**
   ```bash
   git clone https://github.com/hicka/bedexa.git
   cd bedexa
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JS/CSS dependencies & build assets**
   ```bash
   npm install
   npm run dev
   ```

4. **Configure your environment**
   ```bash
   cp .env.example .env
   # Edit .env: database credentials, APP_KEY, mail settings, etc.
   php artisan key:generate
   ```

5. **Run migrations & seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the application**
   ```bash
   php artisan serve
   ```

7. **Log in**
    - Default admin: `admin@example.com` / `password`
    - Change credentials after first login.

## 🔧 Configuration

- **Currency & Exchange Rates**:  
  Configure under **Settings → Currencies**.
- **Tax & Fees**:  
  Define service charges, green tax and no-show fees in **Settings → Fees**.
- **Room Types**:  
  Set up room categories (e.g. Deluxe, Standard) in **Settings → Room Categories**.
- **Email Notifications**:  
  Edit SMTP settings in `.env` and **Settings → Email**.

## 🤝 Contributing

We welcome your help! Please:

1. Fork the repo
2. Create a feature branch (`git checkout -b feature/xyz`)
3. Commit your changes (`git commit -m "Add xyz"`)
4. Push to your fork (`git push origin feature/xyz`)
5. Open a Pull Request against `main`

Please read [CONTRIBUTING.md](./CONTRIBUTING.md) and follow our [Code of Conduct](./CODE_OF_CONDUCT.md).

## 📜 License

**Business Source License 1.1**  
Bedexa’s source is available under BSL 1.1 until **2028-07-23**, after which it automatically converts to **GPL 3.0+**. See [LICENSE](./LICENSE) for full terms.

## 🚧 Roadmap

- Integrate Booking.com & OTA sync
- Mobile-friendly PWA interface
- Automated SMS/email reminders
- Advanced channel management (Airbnb, Expedia)
- Built-in accounting & MIRA compliance reporting

## 💬 Support

If you run into issues, please:

- Check existing issues for solutions
- Report new bugs under “Issues”
- Ask usage questions in the Bedexa Discord channel (invite link in repo)

Thank you for choosing Bedexa! We can’t wait to see how you customize and extend it for your property.
