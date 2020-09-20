<?php

namespace TeamX\Repository\Console;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;

class MakeRepositoryInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'repository:interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository Interface';

    protected $type = 'Repository Interface';
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
        $name_repo = $this->argument('name') . $this->repository.'Interface';
        if (file_exists(str_replace('\\',DIRECTORY_SEPARATOR,config('repository.path.repository')) . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $name_repo . '.php')) {
            $this->info($name_repo . ' already exists !');
        }
        $bind=explode('\\',config('repository.path.repository'));
        $this->namespace=array_pop($bind);
        parent::handle();
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\'.$this->namespace.'\\' . $this->argument('name');
    }
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        return str_replace(['DummyClass', '{{ class }}', '{{class}}'], $class . $this->repository.'Interface', $stub);
    }
    protected function getPath($name)
    {
        $name = \Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name . $this->repository.'Interface') . '.php';
    }
    protected function getStub()
    {
        $stub = '/stubs/RepositoryInterface.stub';
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
