<?php

namespace App\Console\Commands;

use App\Mail\Test\testMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CustomTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:custom-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mail::to('admin@admin.com')->send(new testMail());
    }
}
