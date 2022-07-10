<?php
namespace App;

use Illuminate\Support\Facades\Blade;
use ReflectionClass;
use ReflectionProperty;

class Livewire
{
    function initialRender($class) {
        $component = new $class;

        [$html, $snapshot] = $this->toSnapshot($component);

        $snapshotAttribute = htmlentities(json_encode($snapshot));

        return <<<HTML
            <div wire:snapshot="{$snapshotAttribute}">
            {$html}
            </div>
        HTML;

    }

    function fromSnapshot($snapshot) {
        $class = $snapshot['class'];
        $data = $snapshot['data'];

        $component = new $class();
        $this->setProperties($component, $data);

        return $component;
    }

    function callMethod($component, $method) {
        $component->{$method}();
    }

    function toSnapshot($component) {
        $html = Blade::render($component->render(),
            $this->getProperties($component)
        );

        $snapshot = [
            'class' => get_class($component),
            'data'  => $this->getProperties($component)
        ];

        return [$html, $snapshot];
    }

    function setProperties($component, $props) {
        foreach($props as $key => $value) {
            $component->{$key} = $value;
        }
    }

    function getProperties($component) {
        $props = [];

        $reflectedProps = (new ReflectionClass($component))->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach($reflectedProps as $property) {
            $props[$property->getName()] = $property->getValue($component);
        }

        return $props;
    }

}
