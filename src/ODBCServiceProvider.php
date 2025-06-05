<?php

namespace Henriknordstrom\LaravelPdoOdbcPatched;

use Henriknordstrom\LaravelPdoOdbcPatched\Flavours\Snowflake\Connection;
use Henriknordstrom\LaravelPdoOdbcPatched\Flavours\Snowflake\Connector as SnowflakeConnector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Henriknordstrom\LaravelPdoOdbcPatched\ODBCConnector;

class ODBCServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Connection::resolverFor('odbc', ODBCConnector::registerDriver());
        Connection::resolverFor('snowflake', SnowflakeConnector::registerDriver());
        Connection::resolverFor('snowflake_native', SnowflakeConnector::registerDriver());
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);
        Model::setEventDispatcher($this->app['events']);
    }
}
