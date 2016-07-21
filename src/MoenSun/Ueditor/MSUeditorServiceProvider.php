<?php
/**
 * Created by Bane.Shi.
 * Copyright MoenSun
 * User: Bane.Shi
 * Date: 16/5/2
 * Time: 20:27
 */

namespace MoenSun\Ueditor;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class MSUeditorServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $configPath = __DIR__."/../../../config/msueditor.php";
        $this->mergeConfigFrom($configPath, 'msueditor');
    }

    public function boot(){

        $routeConfig = [
            'namespace' => 'MoenSun\Ueditor\Controllers',
        ];

        $this->getRouter()->group($routeConfig,function($router){
            $router->any('mslaravel-ueditor',["uses"=>"Controller@ueditor"]);
        });

		$configPath = __DIR__."/../../../config/msueditor.php";

		$this->publishes([$configPath => $this->getConfigPath()],'config');
    }

    protected function getRouter()
    {
        return $this->app['router'];
    }

	public function getConfigPath(){
		return config_path("msueditor.php");
	}
	protected function publishConfig($configPath)
	{
		$this->publishes([$configPath => config_path('msueditor.php')], 'config');
	}

}