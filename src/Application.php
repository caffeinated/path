<?php
namespace Caffeinated\Path;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{
    /**
     * The array of custom path config items.
     *
     * @var array
     */
    protected $path;

    /**
     * Create a new instance of Application
     *
     * @param string|null  $basePath
     * @param string|null  $configPath
     */
    public function __construct($basePath = null, $configPath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->path = $this->loadConfig($configPath);

        parent::__construct($basePath);
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @return string
     */
    public function path()
    {
        return $this->basePath.'/'.$this->path['app_path'];
    }

    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function configPath()
    {
        return $this->basePath.'/'.$this->path['config_path'];
    }

    /**
     * Get the path to the database directory.
     *
     * @return string
     */
    public function databasePath()
    {
        return $this->basePath.'/'.$this->path['database_path'];
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath()
    {
        return $this->basePath.'/'.$this->path['lang_path'];
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath.'/'.$this->path['public_path'];
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath()
    {
        return $this->basePath.'/'.$this->path['storage_path'];
    }

    /**
     * Manually load our config file. We need to do this since this file
     * is loaded before the config service provider is kicked in.
     *
     * @return array
     */
    protected function loadConfig($customConfigPath = null)
    {
        if (is_null($customConfigPath)) {
            $customConfigPath = $this->basePath.'/config';
        }

        $pathConfigPath  = realpath(__DIR__.'/../config');
        $pathConfigFile  = $pathConfigPath.'/path.php';
        $customConfigFile = $customConfigPath.'/path.php';

        $customConfig = [];
        $pathConfig  = include($pathConfigFile);

        if (file_exists($customConfigFile)) {
            $customConfig = include($customConfigFile);
        }

        $config = array_replace_recursive($pathConfig, $customConfig);

        if ($customConfigPath) {
            $config['config'] = str_replace($this->basePath.'/', '', $customConfigPath);
        } else {
            $config['config'] = 'config';
        }

        return $config;
    }
}
