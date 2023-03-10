<?php

namespace zedsh\zadmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ZAdminInstallAdminResourceController extends Command
{
    public $signature = 'zadmin:admin-resource-controller';

    public $description = 'Command for copy AdminResourceController file into your project';


    public function __construct() {
        parent::__construct();
    }

    public function handle()
    {
        $this->installAdminResourceController();
    }
    protected function installAdminResourceController()
    {
        (new Filesystem)->copyDirectory(__DIR__.'/assets/expand/AdminResourceController', app_path().'/Http/Controllers/');
    }

}
