<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Services/' . str_replace('\\', '/', $name) . '.php');
        
        $this->ensureDirectoryExists(dirname($path));
        
        $stub = file_get_contents(__DIR__.'/stubs/service.stub');
        $stub = str_replace('{{namespace}}', $this->getNamespace($name), $stub);
        $stub = str_replace('{{class}}', $this->getClassName($name), $stub);
        
        file_put_contents($path, $stub);
        
        $this->info("Service created successfully: {$path}");
    }

    protected function ensureDirectoryExists($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    protected function getNamespace($name)
    {
        return 'App\\Services\\' . str_replace('/', '\\', dirname(str_replace('\\', '/', $name)));
    }

    protected function getClassName($name)
    {
        return basename(str_replace('\\', '/', $name));
    }
}
