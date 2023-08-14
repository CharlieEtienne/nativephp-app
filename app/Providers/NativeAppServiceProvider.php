<?php

namespace App\Providers;

use Native\Laravel\Menu\Menu;
use Native\Laravel\Facades\Window;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Facades\Notification;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        // Window::open();

        // Notification::title('Hello from NativePHP')
        //     ->message('This is a detail message coming from your Laravel app.')
        //     ->show();

        MenuBar::create()
            ->alwaysOnTop()
            ->width(400)
            ->height(410)
            ->withContextMenu(
                Menu::new()
                    ->link('https://github.com/CharlieEtienne', 'Charlie Etienne on GitHub')
                    ->separator()
                    ->quit()
            );
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
