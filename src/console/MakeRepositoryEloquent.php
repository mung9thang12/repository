<?php

namespace Mung9thang12\Repository\Console;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeRepositoryEloquent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'repository:eloquent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository Eloquent';

    protected $type = 'Repository Eloquent';
    protected $repository = 'Repository';
    protected $namespace;

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
        $name_repo = $this->argument('name') . $this->repository;
        if (file_exists(str_replace('\\',DIRECTORY_SEPARATOR,config('repository.path.repository')) . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $name_repo . '.php')) {
            $this->info($name_repo . ' already exists !');
        }
        $bind=explode('\\',config('repository.path.repository'));
        $this->namespace=array_pop($bind);
        parent::handle();
    }
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace('{{class}}', str_replace($this->getNamespace($name) . '\\', '', $name).$this->repository,$stub);
        $stub = str_replace('{{model}}', str_replace($this->getNamespace($name) . '\\', '', $name),$stub);
        parent::replaceNamespace($stub,$name);
        return $this;
    }
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\'.$this->namespace.'\\' . $this->argument('name');
    }
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name); 
        $search=[
            '{{namespaceinterface}}',
            '{{interface}}'
        ];
        $replace=[
            $name.$this->repository.'Interface',
            str_replace($this->getNamespace($name) . '\\', '', $name).$this->repository.'Interface'
        ];
        return str_replace($search,$replace, $stub);
    }
    protected function getPath($name)
    {
        $name = \Str::replaceFirst($this->rootNamespace(), '', $name . $this->repository);

        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
    }
    protected function getStub()
    {
        $stub = '/stubs/Repository.stub';
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
        ? $customPath
        : __DIR__ . $stub;
    }
    protected function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of repository eloquen class.',
                null,
            ],
        ];
    }
}
