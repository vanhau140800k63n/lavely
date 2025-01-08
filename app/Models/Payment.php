<?php

namespace App\Models;

class Payment
{
    public $items = null;

    public function __construct($items)
    {
        $this->items = $items;
    }
}
