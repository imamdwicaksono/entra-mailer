# Entra Mailer for Laravel

Send emails using Microsoft Entra ID (Azure AD / Microsoft 365) with OAuth2 authentication via Microsoft Graph API.

## ✨ Features

- OAuth2 (Client Credentials) Authentication
- Uses Microsoft Graph API to send email
- Laravel Service Provider and Config publish
- Supports Laravel Mailer driver integration (custom mailer)
- Easy to use with `Mail::to(...)->send(...)`

---

## 🛠 Installation

```bash
composer require yourvendor/entra-mailer
php artisan vendor:publish --tag=config


## ENV setting
MAIL_MAILER=entra
ENTRA_CLIENT_ID=your_client_id
ENTRA_CLIENT_SECRET=your_client_secret
ENTRA_TENANT_ID=your_tenant_id
ENTRA_FROM_ADDRESS=your_sender@domain.com
ENTRA_FROM_NAME=Your Name