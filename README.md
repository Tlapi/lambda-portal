# Portal for running Laravel jobs on AWS Lambda 🌌

Run your Jobs effortlessly on AWS Lambda. You can even use Horizon, SQS workers or anything you ever wanted. All you need is just thin client running your queue worker for interaction. And all your jobs will be processed by Lambda Functions.

# Prerequsities

You need to have your Lambda ready. This package uses [bref/bref](https://github.com/brefphp/bref)

# Usage

## Config

In your queue config file:

```
'lambda-sync' => [
    'driver' => 'sqs', // or any other driver
    'key' => env('AWS_KEY'), // you AWS cerdentials will be used to invoke your lambda
    'secret' => env('AWS_SECRET'),
    'region' => env('AWS_REGION'),
    'version' => 'latest',
    'functions' => [
        'queue-name' => 'function-name', // function per queue, if needed
    ],
],

'default_lambda_function' => 'default-function-name', // default function will be called if no function is specified for queue
```

You can specify function for a queue and have default function running all other jobs.

## Job

Then, in your job just use following trait:

```
<?php declare(strict_types = 1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Tlapi\LambdaPortal\DispatchedOnLambda;

class LongJob implements ShouldQueue
{

    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use DispatchedOnLambda;

    /**
     * @var int
     */
    protected $foo;

    public function __construct(int $foo)
    {
        $this->foo = $foo;
    }

    public function handle(): void
    {
        $this->runOnLambda(function () {
            // do something
        });
    }

}

```
