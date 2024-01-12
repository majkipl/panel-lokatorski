<?php

namespace App\Providers;

use App\Interfaces\Query\QueryBus;
use Illuminate\Support\ServiceProvider;

class QueryHandlerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $queryBus = app(QueryBus::class);
        $files = glob(app()->path('Domains/*/Application/Queries/*/*Query.php'));
        foreach ($files as $file) {
            require_once $file;

            $commandClass = $this->getClassName($file);
            $handlerClass = preg_replace('/Query$/', 'Handler', $commandClass);

            if (class_exists($commandClass) && class_exists($handlerClass)) {
                $queryBus->register([$commandClass => $handlerClass]);
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
