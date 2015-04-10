<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

/**
 * Class ButtonFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonFactory
{

    /**
     * The default button class.
     *
     * @var string
     */
    protected $button = 'Anomaly\Streams\Platform\Ui\Button\Button';

    /**
     * The button registry.
     *
     * @var ButtonRegistry
     */
    protected $buttons;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new ButtonFactory instance.
     *
     * @param ButtonRegistry $buttons
     * @param Hydrator       $hydrator
     */
    public function __construct(ButtonRegistry $buttons, Hydrator $hydrator)
    {
        $this->buttons  = $buttons;
        $this->hydrator = $hydrator;
    }

    /**
     * Make a button.
     *
     * @param  array $parameters
     * @return ButtonInterface
     */
    public function make(array $parameters)
    {
        $button = array_pull($parameters, 'button');

        if ($button && $button = $this->buttons->get($button)) {
            $parameters = array_replace_recursive($button, array_except($parameters, 'button'));
        }

        $button = app()->make(array_get($parameters, 'button', $this->button), $parameters);

        $this->hydrator->hydrate($button, $parameters);

        return $button;
    }
}
