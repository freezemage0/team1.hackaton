<?php
require_once '../../bootstrap.php';

use DependencyInjection\Example\Foo;
use DependencyInjection\Example\Bar;
use DependencyInjection\Container;

// Создаем объект контейнера.
$container =  new Container();

// Определяем класс Bar, принимающий в свой конструктор строку $str.
$container->define(Bar::class, array('str' => 'bar'));

// Получаем объект класса Foo, требующего в конструкторе объект класса Bar
// (контейнер сам распознает имеющиеся зависимости, если указан класс параметра).
$foo = $container->get(Foo::class);

// Работает :)
$foo->printBar();

// Определяем алиас для класса Foo.
$container->alias('Baz', Foo::class);

// Работает :)
$foo = $container->get('Baz');
$foo->printBar();

// Меняем параметр класса Bar
$container->define(Bar::class, array('str' => 'foo'));

// Если очень нужен синглтон, расшариваем объект класса, теперь он будет браться из кеша.
$container->share(Bar::class);

// Работает :)
$foo = $container->get(Foo::class);
$foo->printBar();

// Меняем параметр класса.
$container->define(Bar::class, array('str' => 'bar'));

// Не работает :(
// (Все норм, это ж старый объект :))
$foo = $container->get(Foo::class);
$foo->printBar();