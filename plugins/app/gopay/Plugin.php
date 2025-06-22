<?php

namespace App\Gopay;

use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'gopay',
            'description' => 'Gopay',
            'author'      => 'app',
            'icon'        => 'icon-shopping-cart'
        ];
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'App\Gopay\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'app.gopay.some_permission' => [
                'tab' => 'gopay',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'gopay' => [
                'label' => 'gopay',
                'url' => Backend::url('app\gopay\controllers\orders'),
                'icon' => 'icon-leaf',
                'permissions' => ['app.gopay.*'],
                'order' => 500,
            ],
            'logs' => [
                'label'       => 'GoPay Logy',
                'url'         => Backend::url('app/gopay/controllers/gopaylogs'),
                'icon'        => 'icon-file-text-o',
                'permissions' => ['app.gopay.*'],
                'order'       => 500,
            ],

        ];
    }
}
