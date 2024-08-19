<?php

namespace App\Http\Controllers\Employees;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employees\StoreEmployeesRequest;
use App\Http\Resources\Employees\EmployeesCollection;
use App\Http\Resources\Employees\EmployeesResource;
use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::handleRequest(function() {
            $companies = Employees::orderBy('created_at', 'desc')
                                  ->paginate(15);
            return new EmployeesCollection($companies);
        });
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
    public function store(StoreEmployeesRequest $request)
    {

        return ResponseHelper::handleRequest(function() use ($request) {
            $validatedData = $request->validated();

            Employees::create($validatedData);
            return response()->json(['messages' => 'Çalışan başarıyla eklendi.'], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ResponseHelper::handleRequest(function() use ($id) {
            $company = Employees::findOrFail($id);
            return new EmployeesResource($company);
        });
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
        return ResponseHelper::handleRequest(function() use ($id) {
            $employe = Employees::findOrFail($id);

            $employe->delete();
            return response()->json(['messages' => 'Çalışan başarıyla silindi.'], 200);
        });
    }

    public function search(Request $request)
    {
        return ResponseHelper::handleRequest(function() use ($request) {
            $query = $request->input('query');

            if (!$query) {
                return response()->json(['messages' => 'Arama terimi girilmelidir.'], 400);
            }

            $companies = Employees::where('first_name', 'like', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return new EmployeesCollection($companies);
        });
    }
}
