<?php

use Musique\Component;

class DeqarSingleReport extends Component
{

    public static function render($args = array())
    {
        parent::renderComponent(basename(__DIR__), $args);
    }
}
