<?php

namespace App\Services;

use DB;

class JobPostingService
{
    /**
     * Create a new class instance.
     */
    public function getJobPostings(string $search = NULL, string $order = NULL, string $columnToBeSorted = NULL, int $pagination = NULL )
    {
        //
        $jobPostings = DB::table('job_postings')->where('deleted_at', '=', null);

        if ($search) {
            $searchTerm = $search;
            $jobPostings = $jobPostings->where(function ($query) use ($searchTerm) {
                return $query->where('job_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('job_description', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($columnToBeSorted && $order) {
            $jobPostings->orderBy($columnToBeSorted, $order);
        }
        $jobPostings = $pagination ? $jobPostings->paginate($pagination)->withQueryString() : $jobPostings->paginate(5)->withQueryString();

        return $jobPostings;
    }
}
