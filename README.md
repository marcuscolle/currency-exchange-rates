# Currency Exchange Rates

This is a simple currency exchange rate application that allows users to fetch the stored currency by date. 

The application uses the [OpenExchangeRate-API](https://openexchangerates.org/) to get the latest exchange rates.


## How to Install

At the first step you must clone the repo from https://github.com/marcuscolle/currency-exchange-rates.git into your preferred folder where you can serve the application.

Now you must open your cloned project, first you need to add the .env file sent by email to the root of the project.

After .env is copied you go to the terminal and run the commands, composer install, then npm install, then npm run dev, php artisan key:generate, php artisan migrate, php artisan serve.

Now you can access the application at your localhost.


## How to Use

On the main page, you can select the date to check the exchange rates stored on the database for that day.


## How Exchange Rates are Stored

These currencies are stored into the database via schedule task that runs every day after UK market closes. After the schedule task runs, the exchange rates get stored into the database and an email is sent to the desired email with a csv file attached.

You can also run manually by running the command php artisan fetch:currency.

I have chosen to store 10 currencies only, but you can store all 169 currencies provided by the api by removing &symbols or add more currencies to the array exchange symbols on config api file.


## To be noticed

I had to use Http::withOptions(['verify' => $sslCertPath]) the $sslCertPath is a path to my ssl certificate, my local environment was generating curl error 60, so I had to use this option to bypass the error. If you have the same issue you can use the same solution or remove the option and test if it works for you. The path is commented on helpers file.


