<?php

declare(strict_types=1);

use Choval\Async\Async;

use function React\Promise\resolve;

function future($i=0)
{
    return new React\Promise\FulfilledPromise($i+1);
}

class Benchmark
{
    public function benchUglyWay()
    {
        future()
          ->then(function ($i) {
              return future($i);
          })
          ->then(function ($i) {
              return future($i);
          })
          ->then(function ($i) {
              return future($i);
          })
          ->then(function ($i) {
              return future($i);
          })
          ->then(function ($i) {
              return $i;
          });
    }

    public function benchNiceWay()
    {
        Async::resolve(function () {
            $i = yield future();
            $i = yield future($i);
            $i = yield future($i);
            $i = yield future($i);
            $i = yield future($i);
            return $i;
        });
    }
}
