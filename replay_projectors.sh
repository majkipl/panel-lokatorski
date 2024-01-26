#!/bin/bash

php artisan event-sourcing:replay App\\Domains\\User\\Application\\Projectors\\AccountBalanceProjector
php artisan event-sourcing:replay App\\Domains\\Payment\\Application\\Projectors\\PaymentProjector
php artisan event-sourcing:replay App\\Domains\\Expense\\Application\\Projectors\\ExpenseProjector
php artisan event-sourcing:replay App\\Domains\\Billing\\Application\\Projectors\\BillingProjector
php artisan event-sourcing:replay App\\Domains\\Balance\\Application\\Projectors\\BalanceProjector
