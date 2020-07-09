<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Console\Application;

/**
 * Trait RegistersCommands
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait RegistersCommands
{

    /**
     * Artisan commands.
     *
     * @var array
     */
    public $commands = [];

    /**
     * Register the Artisan commands.
     */
    protected function registerCommands()
    {
        if (!$this->commands) {
            return;
        }

        Application::starting(function ($artisan) {
            $artisan->resolveCommands($this->commands);
        });
    }
}
