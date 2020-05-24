<?php declare(strict_types=1);

namespace Tlapi\LambdaPortal;

use Illuminate\Container\Container;

/**
 * SQS handler for AWS Lambda that integrates with Laravel Queue.
 */
class LambdaPortalHandler extends LaravelJobHandler
{
    /**
     * @var \Illuminate\Container\Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handleJob($event, $context): void
    {
        echo 'handleSqs';
        var_dump($event);
        var_dump($context);
    }
}
