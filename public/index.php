<?php declare(strict_types=1);
/*
 * This file is part of One Project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
if (PHP_SAPI === 'cli-server') {
    $requestPath = (string) (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');
    $requestPath = rawurldecode($requestPath);
    $file = __DIR__ . $requestPath;
    if ($requestPath !== '/' && is_file($file)) {
        return false;
    }
}

if (is_file(__DIR__ . '/../.env.php')) {
    require __DIR__ . '/../.env.php';
    if (isset($_ENV['ENVIRONMENT'])) {
        $_SERVER['ENVIRONMENT'] = $_ENV['ENVIRONMENT'];
    }
}

if (isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] === 'development') {
    error_reporting(-1);
    ini_set('display_errors', 'On');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_USER_DEPRECATED & ~E_USER_NOTICE);
    ini_set('display_errors', 'Off');
}

if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}

/**
 * -----------------------------------------------------------------------------
 * The One Project
 * -----------------------------------------------------------------------------.
 *
 * The initial user guide for this project is available at:
 *
 * @see https://webisters.com
 */

use Framework\Log\LogLevel;
use Framework\MVC\App;
use Framework\Routing\RouteCollection;

define('ENVIRONMENT', $_SERVER['ENVIRONMENT'] ?? 'production');
define('IS_DEV', ENVIRONMENT === 'development');

/**
 * -----------------------------------------------------------------------------
 * Initialize the App
 * -----------------------------------------------------------------------------.
 *
 * For details on how to set service configs visit:
 *
 * @see https://webisters.com
 */
$app = new App([
    'exceptionHandler' => [
        'default' => [
            'environment' => ENVIRONMENT,
            'logger_instance' => 'default',
        ],
    ],
    'logger' => [
        'default' => [
            'destination' => __DIR__ . '/../storage/logs',
            'level' => LogLevel::ERROR,
        ],
    ],
], IS_DEV);

/**
 * -----------------------------------------------------------------------------
 * Serve Routes
 * -----------------------------------------------------------------------------.
 *
 * For details on how to serve routes visit:
 *
 * @see https://webisters.com
 */
App::router()->serve(null, static function (RouteCollection $routes) : void {
    $routes->get('/', static function () : array {
        return [
            'message' => 'I am the One! You found me.',
        ];
    });
    $routes->get('/about', static function () : string {
        return 'Do you want to know about <strong>me</strong>?';
    }, 'about');
    $routes->notFound(static fn () : array => [
        'message' => 'Route not found.',
    ]);
});

/**
 * -----------------------------------------------------------------------------
 * Running!
 * -----------------------------------------------------------------------------.
 *
 * For details on how to run the app visit:
 *
 * @see https://webisters.com
 */
$app->runHttp();
