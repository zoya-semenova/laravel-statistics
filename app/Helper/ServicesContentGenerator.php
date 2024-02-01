<?php

namespace App\Helper;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Illuminate\Support\Str;

abstract class ServicesContentGenerator implements Arrayable{

    protected $ignore = [];
    protected $_data = [];
    protected $snakeCase = false;


    public function toArray(): array
    {
        return $this
            ->items()
            ->all();
    }

    protected function items()
    {
        $class = new ReflectionClass($this);

        $publicProperties = collect($class->getProperties(ReflectionProperty::IS_PUBLIC))
            ->reject(function (ReflectionProperty $property) {
                return $this->shouldIgnore($property->getName());
            })
            ->mapWithKeys(function (ReflectionProperty $property) {
                return [$this->resolveName($property->getName()) => $this->{$property->getName()}];
            });

        $publicMethods = collect($class->getMethods(ReflectionMethod::IS_PUBLIC))
            ->reject(function (ReflectionMethod $method) {
                return $this->shouldIgnore($method->getName());
            })
            ->mapWithKeys(function (ReflectionMethod $method) {
                return [$this->resolveName($method->getName()) => $this->createVariableFromMethod($method)];
            });

        return $publicProperties->merge($this->_data)->merge($publicMethods);
    }

    protected function createVariableFromMethod(ReflectionMethod $method)
    {
        if ($method->getNumberOfParameters() === 0) {
            return $this->{$method->getName()}();
        }

        return Closure::fromCallable([$this, $method->getName()]);
    }

    protected function shouldIgnore(string $methodName): bool
    {
        if (Str::startsWith($methodName, '__')) {
            return true;
        }

        return in_array($methodName, $this->ignoredMethods());
    }

    protected function ignoredMethods(): array
    {
        return array_merge([
            'toArray',
            'toResponse',
            'view',
        ], $this->ignore);
    }

    protected function resolveName(string $name): string
    {
        if (! $this->snakeCase) {
            return $name;
        }

        return Str::snake($name);
    }
}
