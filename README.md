### Bunk Manager
---
#### Instructions for development of the project 
1. Clone this repository
2. Install [Composer (Package Manager of PHP)](https://getcomposer.org/download/) on your PC
3. Install [Node.js](https://www.nodejs.org) on your PC
4. Run ``composer require`` in the project directory to get all the PHP packages.
5. Run ``npm install`` in the project directory to get all the NPM packages.
6. Copy ``.env-example`` and rename it to ``.env``.
7. Make relevant changes to the DATABASE section in the .env file.
8. Run ``php artisan migrate`` to run the migrations on the database.
9. Run ``php artisan serve`` to run the laravel backend. 
10. When making changes to the Vue Components, use ``npm run dev`` for hot reloading.
