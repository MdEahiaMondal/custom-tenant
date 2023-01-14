<?php

namespace App\Service;

use Exception;
use App\Models\Tenant;
use Illuminate\Validation\ValidationException;
use Symfony\Component\CssSelector\Exception\ParseException;

class TenantService
{

    private static $tenant;
    private static $domain;
    private static $database;

    public static function switchToTenant(Tenant $tenant)
    {
        if (!$tenant instanceof Tenant) {
            // throw error or tenant class
            throw ValidationException::withMessages(['field_name' => 'This value is incorrect']);
        }
        \DB::purge('root_app');
        \DB::purge('tenancy');
        \Config::set('database.connections.tenancy.database', $tenant->database);

        Self::$tenant = $tenant;
        Self::$domain = $tenant->domain;
        Self::$database = $tenant->database;

        \DB::connection('tenancy')->reconnect();
        \DB::setDefaultConnection('tenancy');
    }

    public static function switchToDefault()
    {
        \DB::purge('root_app');
        \DB::purge('tenancy');
        \DB::connection('root_app')->reconnect();
        \DB::setDefaultConnection('root_app');
    }


    public static function getTenant()
    {
        return Self::$tenant;
    }

}
