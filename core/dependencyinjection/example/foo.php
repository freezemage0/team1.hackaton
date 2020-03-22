<?php
namespace DependencyInjection\Example;

class Foo
{
    private $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }

    public function printBar()
    {
        echo $this->bar->print() . PHP_EOL;
    }
}
