<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $interfaceRepositoryFiles = glob(app()->path('Domains/*/Domain/Repositories/*RepositoryInterface.php'));

        foreach ($interfaceRepositoryFiles as $file) {
            require_once $file;

            $commandClass = $this->getClassName($file);

            $pattern = '/App\\\\Domains\\\\(\w+)\\\\Domain\\\\Repositories\\\\(\w+)RepositoryInterface/';
            $replacement = 'App\Domains\\\\\\1\Infrastructure\Repositories\\\\\\2Repository';
            $repositoryClass = preg_replace($pattern, $replacement, $commandClass);

            if (interface_exists($commandClass) && class_exists($repositoryClass)) {
                $this->app->bind($commandClass, $repositoryClass);
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
