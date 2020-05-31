# Portal for running Laravel jobs on AWS Lambda 🌌

Run your Jobs effortlessly on AWS Lambda. You can even use Horizon, SQS workers or anything you ever wanted. All you need is just thin client running your queue worker for interaction. And all your jobs will be processed by Lambda Functions.

# Why?

Some jobs may require much more memory then others. And you maybe dont want to over-provision you instance running your queue worker. This way, you can run these jobs on lambda and keep your worker instance small.

# Prerequsities

You need to have your Lambda ready. This package uses [bref/bref](https://github.com/brefphp/bref)

# Usage

## Packaging for Lambda

We use [bref/bref](https://github.com/brefphp/bref) and `bref/laravel-bridge` package to use our Laravel app on Lambda. You can use same settings as in provided serverless config and then just `serverless deploy` 😎

## Entry point

Copy `worker.php` from this repo to your `public` folder or anywhere else specified in your serverless config. You can check servereless config demo in this repo.

## Config

In your queue config file:

```
'lambda-sync' => [
    'driver' => 'sqs', // or any other driver
    'key' => env('AWS_KEY'), // you AWS cerdentials will be used to invoke your lambda
    'secret' => env('AWS_SECRET'),
    'region' => env('AWS_REGION'),
    'version' => 'latest',
    'function' => 'lambda-function-name',
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
