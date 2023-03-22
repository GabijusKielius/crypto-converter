## About Crypto Converter

Crypto Converter is a web application, which allows users to easily convert currencies via publically available APIs. User input is automatically saved into database.

## Requirements

These are the technologies used for project development

- PHP ^8.2
- Laravel ^10.0
- Vue ^3.2.41
- Node ^v18.15.0
- Docker ^20.10.23
- NPM ^9.5.0
- Composer ^2.5.4

## Launching Development

Project is using [Laravel Sail](https://laravel.com/docs/10.x/sail). You may use different services or Docker directly, but for clarity sake all commands will use Sail in mind

After cloning repository, run the following steps:

- Install composer dependancies - `composer install`
- Install Node dependancies - `npm install`
- Create .env - `cp .env.example .env`
- _(Optional)_ Acquire [Coin API](https://docs.coinapi.io/) free API key, add it to `.env` variable `COIN_API_KEY`
- Build docker container images - `./vendor/bin/sail build` - if needed, use `--no-cache` flag
- Start docker container - `./vendor/bin/sail up`
- Run migrations - `./vendor/bin/sail php artisan migrate`
- Start the development server - `npm run dev`

## Usage

Project acts as both SPA and API application:
1. You can open [localhost](http://localhost) with your preferred browser
2. Alternatively, you can use [Postman](https://www.postman.com/), cURL or similar services to call API endpoint

## API Endpoint

Currency Conversion endpoint is `http://localhost/api/currency/convert` (POST), the body example goes as follows:
```
{
    "from_amount":123,
    "from_currency":"EUR",
    "to_currency":"BTC"
}
```
If successful, the response will go as follows:
```
{
    "from_currency": "EUR",
    "from_amount": 123,
    "to_currency": "BTC",
    "to_amount": 0.004677,
    "api_provider": "Exchange Rate",
    "updated_at": "2023-03-22T13:20:42.000000Z",
    "created_at": "2023-03-22T13:20:42.000000Z",
    "id": 7
}
```
While feature is called `crypto` converter and it should be used for this purpose, it can be used to convert currencies to other real-life currencies.
