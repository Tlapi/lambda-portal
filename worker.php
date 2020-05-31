<?php declare(strict_types = 1);

use Tlapi\LambdaPortal\LambdaPortalHandler;

require env('VENDOR_PATH', __DIR__ . '/..') . '/vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require __DIR__ . '/../bootstrap/app.php';

$app->useStoragePath('/tmp');

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

return $app->makeWith(LambdaPortalHandler::class);
