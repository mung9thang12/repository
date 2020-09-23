<?php

namespace Mung9thang12\Repository\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository';

    protected $type = 'Repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        if (file_exists(config('repository.path.repository') . '/' . $name)) {
            $this->info($name . ' Repository already exists !');
        }

        $this->call('repository:interface',['name'=>$name]);
        $this->call('repository:eloquent',['name'=>$name]);

        //make model
        if($this->option('model')){
            $this->call('make:model',['name'=>$name]);
        }
    }
    
    protected function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of repository class.',
                null,
            ],
        ];
    }
    protected function getOptions()
    {
        return [
            [
                'model',
                null,
                InputOption::VALUE_NONE,
                'Create a new model class.'
            ]
        ];
    }
}
