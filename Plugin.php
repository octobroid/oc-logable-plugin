<?php namespace Octobro\Logable;

use Backend;
use System\Classes\PluginBase;

/**
 * Logable Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Logable',
            'description' => 'No description provided yet...',
            'author'      => 'Octobro',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Octobro\Logable\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'octobro.logable.some_permission' => [
                'tab' => 'Logable',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'logable' => [
                'label'       => 'Logable',
                'url'         => Backend::url('octobro/logable/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['octobro.logable.*'],
                'order'       => 500,
            ],
        ];
    }
}
