<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
     public function handle()
     {
       $this->info('Display this on the screen');
       $repository = $this->argument('repository');

       $path = $this->viewPath($repository);

       $this->createDir($path);

       if (File::exists($path))
       {
         $this->error("File {$path} already exists!");
         return;
       }

       File::put($path, $path);

       $this->info("File {$path} created.");
     }

     public function viewPath($repository)
     {
       $repository = str_replace('.', '/', $repository) . '.php';

       $path = "app/Repositories/Repository/{$repository}";

       return $path;
     }

     public function createDir($path)
     {
       $dir = dirname($path);

       if (!file_exists($dir))
       {
         mkdir($dir, 0777, true);
       }
     }
}
