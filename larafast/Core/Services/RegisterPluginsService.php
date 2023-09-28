<?php

namespace Larafast\Core\Services;

class RegisterPluginsService
{
    public function getPluginInfoFiles($directory)
    {
        $pluginInfoFiles = [];

        if ($handle = opendir($directory)) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry != '.' && $entry != '..') {

                    $path = $directory.'/'.$entry;

                    if (is_dir($path)) {
                        $subpluginInfoFiles = $this->getPluginInfoFiles($path);
                        $pluginInfoFiles = array_merge($pluginInfoFiles, $subpluginInfoFiles);
                    } elseif (is_file($path) && $entry == 'plugin-info.php') {
                        $pluginInfoFiles[] = $path;
                    }
                }
            }
            closedir($handle);
        }

        return $pluginInfoFiles;
    }

    public function register()
    {
        $pluginInfoFilesPaths = $this->getPluginInfoFiles(base_path('larafast/plugins'));
        $providers = ' ';

        foreach ($pluginInfoFilesPaths as $filePath) {

            $file = require $filePath;

            if ($file['status'] === 'active' && class_exists('\\'.str_replace('/', '\\', $file['service_provider']))) {

                $providers .= '$this->app->register(\\'.str_replace('/', '\\', $file['service_provider']).'::class);';

                $this->createSymlink($file['plugin_public_dir_path'], public_path($file['plugin_dir_name']));
            }
        }

        $larafastServiceProviderFile = base_path('larafast/Core/LarafastServiceProvider.php');
        $serviceProviderFileContents = file_get_contents($larafastServiceProviderFile);

        $pattern = '/private function registerPlugins\(\)(\s*){[^}]*}/';

        $providers = preg_replace($pattern, "private function registerPlugins() {\n".trim($providers)."\n}", $serviceProviderFileContents);

        file_put_contents($larafastServiceProviderFile, $providers);
    }

    public function createSymlink($target, $link)
    {
        if (! windows_os()) {
            return symlink($target, $link);
        }

        $mode = is_dir($target) ? 'J' : 'H';

        exec("mklink /{$mode} ".escapeshellarg($link).' '.escapeshellarg($target));
    }
}
