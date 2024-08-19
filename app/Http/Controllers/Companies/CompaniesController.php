<?php

namespace App\Http\Controllers\Companies;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Companies\StoreCompanyRequest;
use Illuminate\Http\Request;
use App\Http\Resources\Companies\CompaniesCollection;
use App\Http\Resources\Companies\CompaniesResource;
use App\Models\Companies;
use Illuminate\Support\Facades\Storage;


class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::handleRequest(function() {
            $companies = Companies::with('employees')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
            return new CompaniesCollection($companies);
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
    public function store(StoreCompanyRequest $request)
    {
        return ResponseHelper::handleRequest(function() use ($request) {
            $validatedData = $request->validated();

             // logo add storage
            if ($request->hasFile('logo')) {
                $logoUrl = $request->file('logo')->store('logos', 'public');
                $validatedData['logo'] = "http://127.0.0.1:8000/storage/" . $logoUrl;
            }

            Companies::create($validatedData);
            return response()->json(['messages' => 'Şirket başarıyla eklendi.'], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ResponseHelper::handleRequest(function() use ($id) {
            $company = Companies::with('employees')->findOrFail($id);
            return new CompaniesResource($company);
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
            $company = Companies::findOrFail($id);
            if ($company->logo && @strpos($company->logo, "storage/") !== false) {
                $logoPath = explode('storage/', $company->logo)[1];
                $logoPath = 'public/' . $logoPath;
                if (Storage::exists($logoPath)) {
                    Storage::delete($logoPath);
                }
            }

            $company->delete();
            return response()->json(['messages' => 'Şirket başarıyla silindi.'], 200);
        });
    }

    public function getAllCompanies()
    {
        return ResponseHelper::handleRequest(function() {
            $companies = Companies::all();
            return new CompaniesCollection($companies);
        });
    }

    public function search(Request $request)
    {
        return ResponseHelper::handleRequest(function() use ($request) {
            $query = $request->input('query');

            if (!$query) {
                return response()->json(['messages' => 'Arama terimi girilmelidir.'], 400);
            }

            $companies = Companies::where('name', 'like', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return new CompaniesCollection($companies);
        });
    }
}
