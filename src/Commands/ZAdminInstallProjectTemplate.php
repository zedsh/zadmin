<?php

namespace zedsh\zadmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ZAdminInstallProjectTemplate extends Command
{
    public $signature = 'zadmin:project-template';

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
        (new Filesystem)->copyDirectory(__DIR__.'/assets/expand/ProjectTemplate', app_path());
    }

}
