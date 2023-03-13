<?php

namespace zedsh\zadmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ZAdminCreateController extends Command
{
    public $signature = 'admin:create {modelName}';

    public $description = 'Command for copy AdminResourceController file into your project';


    public function __construct() {
        parent::__construct();
    }

    public function handle()
    {
        $this->createController();
    }
    protected function createController()
    {
        $this->comment($this->argument('modelName'));
    }

}
