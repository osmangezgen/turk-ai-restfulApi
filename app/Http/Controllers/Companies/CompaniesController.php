<?php

namespace App\Http\Controllers\Companies;

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
        $companies = Companies::with('employees')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        return new CompaniesCollection($companies);
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

        $validatedData = $request->validated();

         // logo add storage
         if ($request->hasFile('logo')) {
            $logoUrl = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = "http://127.0.0.1:8000/storage/" . $logoUrl;
        }

        Companies::create($validatedData);
        return response()->json(['messages' => 'Şirket başarıyla eklendi.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Companies::with('employees')->findOrFail($id);
        return new CompaniesResource($company);
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
        $company = Companies::findOrFail($id);

        if ($company->logo) {
            $logoPath = explode('storage/', $company->logo)[1];
            $logoPath = 'public/' . $logoPath;
            if (Storage::exists($logoPath)) {
                Storage::delete($logoPath);
            }
        }

        $company->delete();
        return response()->json(['message' => 'Şirket başarıyla silindi.'], 200);
    }
}
