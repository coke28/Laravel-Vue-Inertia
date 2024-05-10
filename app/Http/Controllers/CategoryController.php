<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = DB::table('categories')->where('deleted_at', '=', null);

        if ($request->search) {
            $searchTerm = $request->search;
            $categories = $categories->where(function ($query) use ($searchTerm) {
                return $query->where('category_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('category_description', 'like', '%'.$searchTerm.'%');
            });
        }
        if ($request->columnToBeSorted && $request->order) {
            $categories->orderBy($request->columnToBeSorted, $request->order);
        }
        $categories = $request->pagination ? $categories->paginate($request->pagination)->withQueryString() : $categories->paginate(5)->withQueryString();

        // Transform categories using the API resource
        $transformedCategories = CategoryResource::collection($categories);

        return Inertia::render(
            'Category',
            [
                'data' => $transformedCategories,
                'indexRoute' => 'categories.index',
                'tableColumns' => [
                    ['header_name' => 'ID', 'header_value' => 'id', 'orderable' => true],
                    ['header_name' => 'Category Name', 'header_value' => 'category_name', 'orderable' => true],
                    ['header_name' => 'Category Description', 'header_value' => 'category_description', 'orderable' => true],
                ],
                'tools' => [
                    ['tool_name' => 'index', 'tool_url' => route('categories.index')],
                    ['tool_name' => 'delete', 'tool_url' => 'api/form/delete/'],
                    ['tool_name' => 'edit'],
                    ['tool_name' => 'redirect', 'redirect_url' => '/user'],
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
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
