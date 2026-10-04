<?php

namespace Zoomx\Controllers;


use xPDO\modx\modX;

abstract class Controller
{
    protected $modx;

    public function __construct(modX $modx)
    {
        $this->modx = $modx;
    }
}