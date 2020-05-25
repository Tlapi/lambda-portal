<?php declare(strict_types=1);

namespace Tlapi\LambdaPortal;

use Bref\Context\Context;
use Bref\Event\Handler;

/**
 * Handles SQS events.
 */
abstract class LaravelJobHandler implements Handler
{
    abstract public function handleJob($event, Context $context): void;

    /** {@inheritDoc} */
    public function handle(array $event, Context $context, LambdaPortalService $lambdaPortalService): void
    {
        $this->handleJob($event, $context, $lambdaPortalService);
    }
}
