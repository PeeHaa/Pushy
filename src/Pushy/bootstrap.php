<?php
/**
 * This bootstraps the Pushy library
 *
 * PHP version 5.4
 *
 * @category   Pushy
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    0.0.1
 */
namespace Pushy;

use Pushy\Core\Autoloader;

/**
 * Setup the library autoloader
 */
require_once __DIR__ . '/Core/Autoloader.php';

$autoloader = new Autoloader(__NAMESPACE__, dirname(__DIR__));
$autoloader->register();

/**
 * Setup the composer dependencies autoloader
 */
require __DIR__ . '/../../vendor/autoload.php';
