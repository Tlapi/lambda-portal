<?php declare(strict_types = 1);

namespace Tlapi\LambdaPortal;

use Aws\Lambda\LambdaClient;
use Aws\Result;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\Jobs\SqsJob;
use Illuminate\Queue\Jobs\SyncJob;

class LambdaPortalService
{

    public const CONNECTION_NAME = 'lambda-portal';

    /**
     * @var \Aws\Lambda\LambdaClient
     */
    protected $client;

    public function __construct()
    {
        $this->client = new LambdaClient(config('queue.connections.lambda-sync'));
    }

    public function sendJobToLambda(Job $job): Result
    {
        return $this->client->invoke([
            'FunctionName' => config(sprintf('queue.%s.functions.%s', $job->getConnectionName(), $job->getQueue()), config(sprintf('queue.%s.default_function', $job->getConnectionName()))),
            'Payload' => $job->getRawBody(),
        ]);
    }

    public function processJobByLambda($container, array $payload)
    {
        $queueJob = new SyncJob($container, json_encode($payload), self::CONNECTION_NAME, self::CONNECTION_NAME);
        $queueJob->fire();
    }

}