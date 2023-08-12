<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeEntityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:entity {name : The name of the entity}
                                        {--actions= : Actions for the controller (e.g., crud)}
                                        {--module= : The name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating entity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $actions = $this->option('actions');
        $module = $this->option('module');

        parent::handle();
        $model = Str::studly(str_replace('/', '\\', $this->argument('name')));
        $modelArray = explode('\\', $model);
        if (count($modelArray) > 1) {
            $modelClass = end($modelArray);
        } else {
            $modelClass = $model;
        }
        $modelObject = Str::camel($modelClass);

        $this->createMigration($model);

        $this->createFields($model);

        $this->createRequests($model);

        $this->createServices($model, $modelClass, $modelObject);

        $this->createSearch($model, $modelClass);

        $this->createRepository($model, $modelClass);

        $this->createController($model, $modelClass, $modelObject);
    }

    
}
