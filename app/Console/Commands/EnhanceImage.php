<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EnhanceImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enhance-image {folder}';

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

        $folder = $this->argument('folder');

        // Execute the Python script
        $output = [];
        $exitCode = 0;
        exec('python3 ' . base_path("python/main.py ".$folder), $output, $exitCode);

        //   dd($exitCode, base_path("python3 python/main.py"));
        dd('python3 ' . base_path("python/main.py"), $output, $exitCode);

        // Log the output
        $this->info(implode(PHP_EOL, $output));

        // Log the status based on the exit code
        if ($exitCode === 0) {
            $this->info('Python script executed successfully.');
        } else {
            $this->error("Python not executed successfully!");
        }
    }
}
