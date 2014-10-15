<?php

if (!$loader = include __DIR__ . '/../vendor/autoload.php') {
    $nl = PHP_SAPI === 'cli' ? PHP_EOL : '<br />';
    echo "$nl$nl";
    die('You must set up the project dependencies.' . $nl .
        'Run the following commands in ' . dirname(__DIR__) . ':' . $nl . $nl .
        'curl -s http://getcomposer.org/installer | php' . $nl .
        'php composer.phar install' . $nl);
}

require_once __DIR__ . '/../vendor/symfony/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loaderFitbase = new UniversalClassLoader();
$loaderFitbase->registerNamespace('Fitbase', __DIR__ . '../src/Fitbase');
$loaderFitbase->register();


use Doctrine\Common\Annotations\AnnotationRegistry;

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__ . '/../vendor/symfony/symfony/src/Symfony/Component/Intl/Resources/stubs/functions.php';

    $loader->add('', __DIR__ . '/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs');
}

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
