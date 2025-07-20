<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class CustomFieldProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blueprint::macro('customDefaults', function () {
            $this->boolean('status')->default(1);
            $this->boolean('delete')->default(0);
            $this->foreignId('created_by')->nullable()->references('id')->on('admins');
            $this->foreignId('updated_by')->nullable()->references('id')->on('admins');
        });
    }
}
