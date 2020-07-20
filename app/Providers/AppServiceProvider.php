<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->environment() == 'production') {
            $this->app->bind('path.public', function () {
                return '/home/gestionred/public_html';
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);

        Route::pattern('id', '[0-9]+');

        Route::resourceVerbs([
            'create' => 'crear',
            'edit'   => 'editar',
        ]);

        // Queue::failing(function (JobFailed $event) {
        //     // $event->connectionName
        //     // $event->job
        //     // $event->exception
        //     $data['jobName'] = $event->job->getName();
        //     $data['jsonEncodedData'] = json_encode($event->job->payload());
        //     $data['exception'] = $event->exception;
        //     // Add current timestring
        //     $data['timeString'] = Carbon::now()->toDayDateTimeString();

        //     Mail::send(['text' => 'emails.alert.queueFailing'], $data, function ($msg) {
        //         $msg->to(config('mail.support.address'))
        //             ->from(config('mail.from.address'))
        //             ->subject('Error en cola de trabajo');
        //     });
        // });
    }
}
