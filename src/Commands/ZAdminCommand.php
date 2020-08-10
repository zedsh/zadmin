<?php

namespace Zedsh\ZAdmin\Commands;

use Illuminate\Console\Command;

class ZAdminCommand extends Command
{
    public $signature = 'ZAdmin';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
