<?php

namespace zedsh\zadmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ZAdminCommand extends Command
{
    public $signature = 'zadmin:projecttemplate';

    public $description = 'Command for copy ProjectTemplate file into your project';


    public function __construct() {
        parent::__construct();
    }

    public function handle()
    {
        $this->installBaseProjectTemplate();
    }

    protected function installBaseProjectTemplate()
    {
        (new Filesystem)->copyDirectory(__DIR__.'/../expand/ProjectTemplate', __DIR__.'/../../../../../app/');
    }

}
