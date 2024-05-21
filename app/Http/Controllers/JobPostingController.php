<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobPostingRequest;
use App\Http\Resources\JobPostingResource;
use App\Models\JobPosting;
use App\Services\JobPostingService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobPostingController extends Controller
{
    // private JobPostingService $jobPostingService;

    // public function __construct(JobPostingService $jobPostingService)
    // {
    //     $this->jobPostingService = $jobPostingService;
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, JobPostingService $jobPostingService)
    {

        $jobPostings = $jobPostingService->getJobPostings($request->search, $request->order, $request->columnToBeSorted, $request->pagination);
        // Transform jobPostings using the API resource
        $transformedJobPostings = JobPostingResource::collection($jobPostings);

        return Inertia::render(
            'JobPosting',
            [
                'data' => $transformedJobPostings,
                'dataModel' => 'Job Posting',
                'tableColumns' => [
                    ['header_name' => 'ID', 'header_value' => 'id', 'orderable' => true],
                    ['header_name' => 'Job Name', 'header_value' => 'job_name', 'orderable' => true],
                    ['header_name' => 'Job Description', 'header_value' => 'job_description', 'orderable' => true],
                ],
                'tools' => [
                    'indexRoute' => route('jobPostings.index'),
                    'addRoute' => route('jobPostings.create'),
                    'editRoute' => route('jobPostings.index'),
                    // 'deleteRoute' => route('jobPostings.destroy'),
                ],
                'filters' => [
                    'search' => $request->search,
                    'pagination' => $request->pagination ? $request->pagination : '5',
                    'page' => $request->page,
                    'order' => $request->order,
                    'columnToBeSorted' => $request->columnToBeSorted,
                ],
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Forms/JobPostingForm',
            [
                'storeRoute' => route('jobPostings.store'),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobPostingRequest $request)
    {
        $jobPosting = new JobPosting();
        $jobPosting->job_name = $request->job_name;
        $jobPosting->job_description = $request->job_description;
        $jobPosting->status = $request->status;
        $jobPosting->save();

        return redirect(route('jobPostings.index'))
            ->with([
                'message' => $jobPosting->job_name.' '.'Job Posting Create',
                'type' => 'check',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPosting $jobPosting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPosting $jobPosting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPosting $jobPosting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPosting $jobPosting)
    {
        //
    }
}
