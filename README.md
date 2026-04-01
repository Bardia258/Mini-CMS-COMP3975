# Setup Instructions

## Windows Setup

### Frontend (React)
Run the following commands to install dependencies and start the frontend:

```bash
cd react-frontend
npm install
npm run dev
```
### Backend (Laravel)

Run the following commands to set up and start the backend:
```bash
cd laravel-backend
composer install
Copy-Item .env.example .env
New-Item -ItemType File -Path database\cms-db.sqlite -Force
php artisan migrate --seed
php artisan key:generate
php artisan serve
```
## macOS Setup
### Frontend (React)

Run the following commands to install dependencies and start the frontend:
```bash
cd react-frontend
npm install
npm run dev
```
### Backend (Laravel)

Run the following commands to set up and start the backend:
```bash
cd laravel-backend
composer install
cp .env.example .env
touch database/cms-db.sqlite
php artisan migrate --seed
php artisan key:generate
php artisan serve
```