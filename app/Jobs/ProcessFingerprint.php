<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use App\Models\UserJob;

class ProcessFingerprint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */


    public $timeout = 10000;

    public $randomDirectoryName, $user_id;


    public function __construct($randomDirectoryName,$user_id)
    {
        //
        $this->randomDirectoryName = $randomDirectoryName;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            // dd($this->job->getJobId());

            // $j = new UserJob([
            //     "user_id" => $this->user_id,
            //     "job_id"=> $this->job->getJobId(),
            //     "status"=>"PROCESSING"
            // ]);
            // $j->save();


            // Run the artisan command to execute the Python script
            Artisan::call('app:enhance-image', ['folder' => $this->randomDirectoryName]);

            $output = Artisan::output();

            // // Run the artisan command to execute the Python script
            // Artisan::call('app:enhance-image',['folder'=>$randomDirectoryName]);

            // // Get the output of the command
            // $output = Artisan::output();


        } catch (\Exception $e) {
            // Handle any exceptions that occur

            // $userJob = UserJob::where('user_id', $this->user_id)
            //     ->where('job_id', $this->job->getJobId())
            //     ->first();

            // if ($userJob) {
            //     // Update the status
            //     $userJob->status = 'FAILED';
            //     $userJob->save();

                // You can also chain the update like this:
                // UserJob::where('user_id', auth()->id())
                //        ->where('job_id', $job_id)
                //        ->update(['status' => 'PROCESSING']);
            // } else {
            //     // UserJob not found, handle this case accordingly
            // }

            // dd([
            //     'success' => false,
            //     'message' => 'Failed to execute Python script: ' . $e->getMessage()
            // ]);
        }
    }
}
