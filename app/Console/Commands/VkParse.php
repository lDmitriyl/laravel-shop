<?php

namespace App\Console\Commands;

use App\Services\VkService;
use Illuminate\Console\Command;

class VkParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vk:friends{vk_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to start parsing friends for user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vk_id = $this->argument('vk_id');

        (new VkService())->getFriends($vk_id);
    }
}
