# Laravel PDO ODBC Patched

A Laravel package that provides PDO ODBC connection drivers for Laravel 12, with special support for Snowflake database connections.

This project is forked from [appsfortableau/laravel-pdo-odbc](https://github.com/appsfortableau/laravel-pdo-odbc).

## Description

This package extends Laravel's database functionality to support ODBC connections, with specific optimizations for Snowflake databases. It supports both ODBC connections and native Snowflake PDO driver connections.

## Requirements

- PHP 8.0 or higher
- Laravel 12.0 or higher
- ODBC drivers for your database
- For Snowflake native connections: pdo_snowflake PHP extension

## Installation

You can install the package via composer:

```bash
composer require henriknordstrom/laravel-pdo-odbc-patched
```

The package will automatically register its service provider.

## Configuration

Add a new connection to your `config/database.php` file:

### For general ODBC connections:

```php
'connections' => [
    // ...
    'odbc' => [
        'driver' => 'odbc',
        'odbc_driver' => '/path/to/your/odbc/driver.so', // Required: absolute path to the ODBC driver
        'dsn' => 'your-dsn-string', // Optional: full DSN string
        'host' => 'your-host',
        'database' => 'your-database',
        'username' => 'your-username',
        'password' => 'your-password',
        'options' => [
            // PDO options
        ],
    ],
    // ...
],
```

### For Snowflake via ODBC:

```php
'connections' => [
    // ...
    'snowflake' => [
        'driver' => 'snowflake',
        'odbc_driver' => '/path/to/your/snowflake/odbc/driver.so',
        'host' => 'your-account.snowflakecomputing.com',
        'database' => 'your-database',
        'username' => 'your-username',
        'password' => 'your-password',
        'warehouse' => 'your-warehouse',
        'role' => 'your-role',
        'options' => [
            // PDO options
            'grammar' => [
                'query' => null, // Custom query grammar class
                'schema' => null, // Custom schema grammar class
            ],
            'processor' => null, // Custom processor class
        ],
    ],
    // ...
],
```

### For Snowflake via native PDO driver:

```php
'connections' => [
    // ...
    'snowflake_native' => [
        'driver' => 'snowflake_native',
        'host' => 'your-account.snowflakecomputing.com',
        'database' => 'your-database',
        'username' => 'your-username',
        'password' => 'your-password',
        'warehouse' => 'your-warehouse',
        'role' => 'your-role',
        'options' => [
            // PDO options
        ],
    ],
    // ...
],
```

## Environment Variables

You can set the following environment variables in your `.env` file:

```
SNOWFLAKE_COLUMNS_CASE_SENSITIVE=false
SNOWFLAKE_DISABLE_FORCE_QUOTED_IDENTIFIER=false
```

## Usage

Once configured, you can use the connection like any other Laravel database connection:

```php
use Illuminate\Support\Facades\DB;

// Query using the ODBC connection
$results = DB::connection('odbc')->select('SELECT * FROM your_table');

// Query using the Snowflake connection
$results = DB::connection('snowflake')->select('SELECT * FROM your_table');

// Query using the Snowflake native connection
$results = DB::connection('snowflake_native')->select('SELECT * FROM your_table');
```

## Features

- Support for general ODBC connections
- Specialized support for Snowflake databases
- Support for both ODBC and native Snowflake PDO driver connections
- Custom query grammar for Snowflake
- Custom schema grammar for Snowflake
- Custom processor for Snowflake
- Support for PHP 8.0+ with specialized statement classes

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Author

- Henrik Nordstrom (henrik@webtractive.com)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
