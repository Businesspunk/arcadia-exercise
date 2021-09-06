## About the project

This is an exercise project for Arcadia company. 

## Installation

1. Clone this repository
2. Run "composer install"
3. Run "npm run prod"
4. Setup database connection in .env and run "php artisan migrate"
5. Make sure for redirection from "/" to "/public" (For Apache .htaccess already set up)

## Flexibility and extendable in the future

The system has been developed with aims to be extended or changed in the future,
so it has flexible database drivers to handle different types of storage.
For now, they can accept JSON and CSV files. You can easily switch them in App/Domains/Question/QuestionRepository.php, 
just pass to $dbDriver needed driver.

The source database files in the app storage: storage/app/questions.

