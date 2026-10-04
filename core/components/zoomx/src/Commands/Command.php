<?php

namespace Zoomx\Commands;

use MODX\Revolution\modX;

abstract class Command
{
    protected $modx;

    public function __construct(modX $modx)
    {
        $this->modx = $modx;
    }
}