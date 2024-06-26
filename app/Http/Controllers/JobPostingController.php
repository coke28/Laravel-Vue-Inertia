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
                    'editRoute' => 'jobPostings.edit',
                    'deleteRoute' => 'jobPostings.destroy',
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
                'headerTitle' => 'Create Job Listing',
                'submitRoute' => route('jobPostings.store'),
                'goBackRoute' => route('jobPostings.index'),
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
                'message' => $jobPosting->job_name . ' ' . 'Job Posting Created',
                'type' => 'check',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPosting $jobPosting)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPosting $jobPosting)
    {
        //
        return Inertia::render(
            'Forms/JobPostingForm',
            [
                'headerTitle' => 'Editing Job Listing ID: ' . $jobPosting->id,
                'editMode' => true,
                'submitRoute' => route('jobPostings.update', $jobPosting->id),
                'goBackRoute' => route('jobPostings.index'),
                'jobPosting' => new JobPostingResource($jobPosting),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobPostingRequest $request, JobPosting $jobPosting)
    {
        $jobPosting->job_name = $request->job_name;
        $jobPosting->job_description = $request->job_description;
        $jobPosting->status = $request->status;
        $jobPosting->save();

        return redirect(route('jobPostings.index'))
            ->with([
                'message' => $jobPosting->job_name . ' ' . 'Job Posting Updated',
                'type' => 'check',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();
        return redirect(route('jobPostings.index'))
            ->with([
                'message' => $jobPosting->job_name . ' ' . 'Job Posting Deleted',
                'type' => 'check',
            ]);
    }
}
