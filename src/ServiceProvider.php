<?php
/**
 * Created by PhpStorm.
 * User: veoc
 * Date: 4/09/16
 * Time: 10:21 PM
 */

namespace Thesudoteam\AssetManager;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/asset-manager.php.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');

        Blade::directive('css', function($libs) {
            return "<?php echo app('asset-manager')->css($libs) ?>";
        });

        Blade::directive('js', function($libs) {
            return "<?php echo app('asset-manager')->js($libs) ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/asset-manager.php';
        $this->mergeConfigFrom($configPath, 'asset-manager');

        $this->app->singleton('asset-manager', function() {
            $assets = $this->app['config']->get('asset-manager.assets');
            return new AssetManager($assets);
        });
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('asset-manager.php')], 'config');
    }
}