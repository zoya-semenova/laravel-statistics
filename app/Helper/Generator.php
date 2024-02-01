<?php

namespace App\Helper;

use Illuminate\Support\Str;

class Generator{

    protected function getNameSpace() {
        return (new \ReflectionObject($this))->getNamespaceName();
    }

    protected function createFilterObject($name) {
        return $this->getNameSpace()."\\".Str::studly($name);
    }

    protected function isValidObject($decorator) {
        return class_exists($decorator);
    }
}
