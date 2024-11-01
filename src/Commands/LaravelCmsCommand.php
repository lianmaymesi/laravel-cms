<?php

namespace Lianmaymesi\LaravelCms\Commands;

use Illuminate\Console\Command;

class LaravelCmsCommand extends Command
{
    public $signature = 'laravel-cms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
