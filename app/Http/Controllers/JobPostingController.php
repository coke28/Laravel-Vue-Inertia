<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobPostingResource;
use DB;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jobPostings = DB::table('job_postings')->where('deleted_at', '=', null);

        if ($request->search) {
            $searchTerm = $request->search;
            $jobPostings = $jobPostings->where(function ($query) use ($searchTerm) {
                return $query->where('job_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('job_description', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->columnToBeSorted && $request->order) {
            $jobPostings->orderBy($request->columnToBeSorted, $request->order);
        }
        $jobPostings = $request->pagination ? $jobPostings->paginate($request->pagination)->withQueryString() : $jobPostings->paginate(5)->withQueryString();

        // Transform jobPostings using the API resource
        $transformedJobPostings = JobPostingResource::collection($jobPostings);

        return Inertia::render(
            'JobPosting',
            [
                'data' => $transformedJobPostings,
                'tableColumns' => [
                    ['header_name' => 'ID', 'header_value' => 'id', 'orderable' => true],
                    ['header_name' => 'Job Name', 'header_value' => 'job_name', 'orderable' => true],
                    ['header_name' => 'Job Description', 'header_value' => 'job_description', 'orderable' => true],
                ],
                'tools' => [
                    'indexRoute' => route('jobPostings.index'),
                    'addRoute' => route('jobPostings.create'),
                    'editRoute' => route('jobPostings.destroy'),
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
        return Inertia::render('JobPostingForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
