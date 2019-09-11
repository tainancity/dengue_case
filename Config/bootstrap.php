<?php
CakePlugin::loadAll();
require App::pluginPath('Permissible') . 'Config/init.php';

// Load Composer autoload.
require APP . 'vendor/autoload.php';

// Remove and re-prepend CakePHP's autoloader as Composer thinks it is the
// most important.
// See: http://goo.gl/kKVJO7
spl_autoload_unregister(array('App', 'load'));
spl_autoload_register(array('App', 'load'), true, true);