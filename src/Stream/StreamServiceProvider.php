<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Command\ObserveStreamModelCommand;
use Anomaly\Streams\Platform\Stream\Command\RegisterListenersCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class StreamServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream
 */
class StreamServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new RegisterListenersCommand());
        $this->dispatch(new ObserveStreamModelCommand());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Register stream management bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\StreamModel',
            config('streams::config.streams.model')
        );
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface',
            config('streams::config.streams.repository')
        );
    }
}
