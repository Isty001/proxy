### A simple proxy class generator for PHP. 

By a given class, it generates a proxy, that warps the interface of the original class, 
and only instantiate it, if one of its methods invoked.

Usage:

```php
require_once 'vendor/autoload.php';

use Proxy\Factory;
use Proxy\Tests\Fixtures\TestClass;

$factory = new Factory(__DIR__ .'/proxies');

//The passed arguments will be used, when the original class is instantiated
$proxyObject = $factory->createProxy(TestClass::class, new stdClass(), 'Hello'); 

//Or pass the arguments in an array
$arguments = [new stdClass(), 'Hello'];
$proxyObject = $factory->createProxy(TestClass::class, $arguments); 

//This is when the real class is actually instantiated, stored, tehn the method invoked on it
$proxyObject->someMethod(); 
```

A proxy class will be regenerated only if the original class is modified, removed if doesn't exist.
