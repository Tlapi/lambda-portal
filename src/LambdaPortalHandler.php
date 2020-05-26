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

    /**
     * @var \Tlapi\LambdaPortal\LambdaPortalService
     */
    private $lambdaPortalService;

    public function __construct(Container $container, LambdaPortalService $lambdaPortalService)
    {
        $this->container = $container;
        $this->lambdaPortalService = $lambdaPortalService;
    }

    public function handleJob($event, Context $context): void
    {
        $this->lambdaPortalService->processJobByLambda($this->container, $event);
    }
}
