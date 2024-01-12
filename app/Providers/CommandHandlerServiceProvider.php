<?php

namespace App\Providers;

use App\Interfaces\Command\CommandBus;
use Illuminate\Support\ServiceProvider;

class CommandHandlerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $commandBus = app(CommandBus::class);
        $files = glob(app()->path('Domains/*/Application/Commands/*/*Command.php'));
        foreach ($files as $file) {
            require_once $file;

            $commandClass = $this->getClassName($file);
            $handlerClass = preg_replace('/Command$/', 'Handler', $commandClass);

            if (class_exists($commandClass) && class_exists($handlerClass)) {
                $commandBus->register([$commandClass => $handlerClass]);
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
