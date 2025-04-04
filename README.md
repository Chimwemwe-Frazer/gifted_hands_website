# Must Systems Laravel Starter Kit

A modern Laravel starter kit featuring Tailwind CSS and Alpine.js, providing a solid foundation for your next Laravel project with pre-built authentication and authorization.

## Features

- ✨ Modern Dashboard Layout
- 🔐 Complete Authentication System
- 🛡️ Role-Based Authorization
- 🎨 Tailwind CSS for Styling
- 🔄 Alpine.js for Frontend Interactivity
- 📱 Responsive Design
- 📊 Ready-to-use Dashboard Components

## Requirements

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL/MariaDB

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd must-systems-starter-kit-blade
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Copy environment file and configure:
```bash
cp .env.example .env
```
Edit the `.env` file with your database credentials.

5. Generate application key:
```bash
php artisan key:generate
```

6. Run database migrations and seed:
```bash
php artisan migrate --seed
```

7. Run laravel and node.js:
```bash
composer run dev
```


## Project Structure

```
├── app/                 # Core application files
├── config/             # Configuration files
├── database/           # Database migrations and seeds
├── public/             # Public assets
├── resources/          # Views, CSS, and JavaScript
├── routes/             # Route definitions
└── tests/              # Test files
```

## Usage

1. Access the application at `http://localhost:8000`
2. Default login credentials:
   - Email: promisemphoola2@gmail.com
   - Password: 1234567890

## Available Commands

- `php artisan serve` - Start the development server
- `php artisan migrate` - Run database migrations
- `php artisan migrate:fresh` - Reset and re-run migrations
- `npm run dev` - Watch assets during development
- `npm run build` - Build assets for production

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please open an issue in the GitHub repository.

---

Built with ❤️ by Must Systems Developers