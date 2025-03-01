<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disini adalah deskripsi terkait command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('Apakah kamu yakin?')) {
            $bar = $this->output->createProgressBar(20);
            $bar->start();

            for ($i=1; $i <= 20; $i++) {
                $bar->advance();
            }

            $bar->finish();
        }else{
            $this->info('Command dibatalkan');
        }
    }
}
