# Laravel Food Delivery System (Multi-Tenant)

A full-featured food ordering platform built with **Laravel 11**, **Vue 3**, and **Inertia.js**.

## Features
- **Admin Dashboard**: Manage restaurants and cities.
- **Vendor Panel**: Manage menus (Categories & Products) and staff.
- **Staff Dashboard**: Manage incoming orders (Pending -> Preparing -> Ready).
- **Customer Side**: Browse restaurants, add to cart, and place orders.
- **Multi-Tenancy**: Data isolation so vendors only see their own orders.

## Tech Stack
- **Backend**: Laravel
- **Frontend**: Vue.js 3 (Composition API)
- **Adapter**: Inertia.js (Ziggy for Routing)
- **Styling**: Tailwind CSS
- **Database**: SQLite / MySQL

## Installation
1. Clone the repo
2. Run `composer install` and `npm install`
3. Copy `.env.example` to `.env`
4. Run `php artisan key:generate`
5. Run `php artisan migrate --seed`
6. Run `npm run dev` and `php artisan serve`
