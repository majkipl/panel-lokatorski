<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $serviceProviderFiles = glob(app()->path('Domains/*/Infrastructure/Providers/*ServiceProvider.php'));

        foreach ($serviceProviderFiles as $file) {
            require_once $file;

            $providerClass = $this->getClassName($file);

            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }
        }
    }

    /**
     * @param string $filePath
     * @return string
     */
    private function getClassName(string $filePath): string
    {
        $class = trim(str_replace([app_path(), '.php', '/'], ['', '', '\\'], $filePath), '\\');
        return "App\\" . $class;
    }
}
