<?php

namespace App\Console\Commands;

use App\Mail\InterviewCancel;
use App\Models\InterviewDate;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HandleInterview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:handle-interview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel all the Interview that are out dated and not attended';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today(); // Get the current date as a Carbon instance
        $sqlFormattedDate = $today->format('Y-m-d');
        $out_dated_interview = InterviewDate::whereDate('interview_date', '<', $sqlFormattedDate)->where('status', 0)->where('is_cancelled', 0)->with('candidate', 'job_applicant')->get();
        
        Log::info('Inside the handleInterview');
     
        foreach ($out_dated_interview as $interview_date) {
            Log::info($interview_date->interview_date . ' is outdated');
            $candidate = $interview_date->candidate;
            $job_applicant = $interview_date->job_applicant;


            $interview_date->update([
                'is_cancelled' => 1
            ]);

            if ($job_applicant) {
                Mail::to($candidate->email)->send(new InterviewCancel($interview_date, $candidate, $job_applicant));
            } else {
                Mail::to($candidate->email)->send(new InterviewCancel($interview_date, $candidate));
            }
        }
    }
}
