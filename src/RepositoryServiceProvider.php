<?php
namespace TeamX\Repository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
	function register(){
        $this->publishes([__DIR__.'/comfig.php'=>config_path('repository.php')],'configRepository');
        if(!file_exists(config_path('repository.php'))){
            $this->mergeConfigFrom(__DIR__.'/config.php','repository');
        }
    }
	function boot(){
        $this->commands([
            \TeamX\Repository\Console\MakeRepository::class,
            \TeamX\Repository\Console\MakeRepositoryEloquent::class,
            \TeamX\Repository\Console\MakeRepositoryInterface::class,
        ]);
        foreach(glob(app_path('Repositories/*')) as $file){
            foreach(glob($file.'/*.php') as $file){
                $arr=explode('/',$file);
                $files[]=explode('.',array_pop($arr))[0];
            }
                $repository=config('repository.path.repository').'\\'.str_replace('Repository','',$files[0]).'\\'.$files[0];
                $interface=config('repository.path.repository').'\\'.str_replace('Repository','',$files[0]).'\\'.$files[1];
                $this->app->bind($interface,$repository);
                $files=[];
        }
	}
}