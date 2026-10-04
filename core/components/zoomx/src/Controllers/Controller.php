<?php

namespace Zoomx\Controllers;

use MODX\Revolution\modX;

abstract class Controller
{
    protected $modx;

    public function __construct(modX $modx)
    {
        $this->modx = $modx;
    }
}