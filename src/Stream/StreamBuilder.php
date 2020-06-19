<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Field\FieldBuilder;
use Anomaly\Streams\Platform\Field\FieldFactory;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamBuilder
{

    /**
     * Build a stream.
     *
     * @param array $stream
     * @return StreamInterface
     */
    public static function build(array $stream)
    {

        /**
         * Build our components and
         * configure the application.
         */
        $fields = Arr::pull($stream, 'fields', []);
        
        // (new Workflow([
        //     'step_name' => $closure
        // ]))->process();

        $stream = StreamInput::read($stream);
        $stream = StreamFactory::make($stream);

        $fields = FieldBuilder::build($fields);
        $fields = FieldFactory::make($fields);

        $stream->fields = $fields;

        /**
         * @todo Revisit
         */
        //Gate::policy(get_class($stream->model), $stream->config('policy', Policy::class));

        $stream->fire('built', compact($stream));

        return $stream;
    }
}
