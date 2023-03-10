<?php

namespace zedsh\zadmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ZAdminInstallAssets extends Command
{
    public $signature = 'zadmin:assets';

    public $description = 'Command for copy assets into your project';


    public function __construct() {
        parent::__construct();
    }

    public function handle()
    {
        $this->installAssets();
    }

    protected function installAssets()
    {
        (new Filesystem)->copyDirectory(__DIR__.'/../../assets/admin_assets', public_path('admin_assets'));
    }

}
