<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomSchedule extends Command
{
    protected $signature = 'custom:schedule';
    protected $description = 'Custom schedule command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
    
        // カスタムコマンドのロジックをここに実装
        $format = new \App\Models\Format();
        $format->updatePreviousAt();
        $format->updatePreviousEnd();
        $this->info('Custom schedule command executed successfully.');
        
    }
}