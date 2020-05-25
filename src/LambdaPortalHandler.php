<?php declare(strict_types=1);

namespace Tlapi\LambdaPortal;

use Bref\Context\Context;
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

    public function handleJob(array $event, Context $context, LambdaPortalService $lambdaPortalService): void
    {
        echo 'handleSqs';
        var_dump($event);
        var_dump($context);
        $lambdaPortalService->processJobByLambda($this->container, $event);
    }
}
