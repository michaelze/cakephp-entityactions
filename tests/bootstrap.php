<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use Cake\Routing\Router;

require_once 'vendor/autoload.php';

error_reporting(E_ALL & ~E_USER_DEPRECATED);

require_once 'vendor/cakephp/cakephp/src/basics.php';

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__));
define('APP_DIR', 'TestApp');

define('TMP', sys_get_temp_dir() . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('SESSIONS', TMP . 'sessions' . DS);

define('CAKE_CORE_INCLUDE_PATH', ROOT);
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);
define('CORE_TESTS', CORE_PATH . 'tests' . DS);
define('CORE_TEST_CASES', CORE_TESTS . 'TestCase');
define('TEST_APP', CORE_TESTS . 'test_app' . DS);

// Point app constants to the test app.
define('APP', TEST_APP . 'TestApp' . DS);
define('WWW_ROOT', TEST_APP . 'webroot' . DS);
define('CONFIG', TEST_APP . 'config' . DS);

//@codingStandardsIgnoreStart
@mkdir(LOGS);
@mkdir(SESSIONS);
@mkdir(CACHE);
@mkdir(CACHE . 'views');
@mkdir(CACHE . 'models');
//@codingStandardsIgnoreEnd

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);
Configure::write('App', [
    'namespace' => 'TestApp',
    'encoding' => 'UTF-8',
    'base' => false,
    'baseUrl' => false,
    'dir' => APP_DIR,
    'webroot' => 'webroot',
    'wwwRoot' => WWW_ROOT,
    'fullBaseUrl' => 'http://localhost',
    'imageBaseUrl' => 'img/',
    'jsBaseUrl' => 'js/',
    'cssBaseUrl' => 'css/',
    'paths' => [
        'plugins' => [TEST_APP . 'Plugin' . DS],
        'templates' => [APP . 'Template' . DS],
        'locales' => [APP . 'Locale' . DS],
    ]
]);

Cache::setConfig([
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true
    ],
    '_cake_model_' => [
        'engine' => 'File',
        'prefix' => 'cake_model_',
        'serialize' => true
    ]
]);

// Ensure default test connection is defined
if (!getenv('db_dsn')) {
    putenv('db_dsn=sqlite:///:memory:');
}

ConnectionManager::setConfig('test', ['url' => getenv('db_dsn')]);
ConnectionManager::setConfig('test_custom_i18n_datasource', ['url' => getenv('db_dsn')]);

Configure::write('Session', [
    'defaults' => 'php'
]);

Log::setConfig([
    'debug' => [
        'engine' => 'Cake\Log\Engine\FileLog',
        'levels' => ['notice', 'info', 'debug'],
        'file' => 'debug',
    ],
    'error' => [
        'engine' => 'Cake\Log\Engine\FileLog',
        'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        'file' => 'error',
    ]
]);

Cake\Chronos\Chronos::setTestNow(Cake\Chronos\Chronos::now());

Router::reload();

ini_set('intl.default_locale', 'en_US');
