<?php

namespace App\Http\Controllers\Employees;

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
        try {
            $companies = Employees::orderBy('created_at', 'desc')
                                    ->paginate(15);
            return new EmployeesCollection($companies);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Bir hata oluştu.'], 500);
        }
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
        $validatedData = $request->validated();

        try {
            Employees::create($validatedData);
            return response()->json(['messages' => 'Çalışan başarıyla eklendi.'], 201);
        } catch (\Exception $e) {
            return response()->json(['messages' => 'Beklenmedik bir hata oluştu.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $company = Employees::findOrFail($id);
            return new EmployeesResource($company);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['messages' => 'Çalışan bulunamadı.'], 404);
        } catch (\Exception $e) {
            return response()->json(['messages' => 'Beklenmedik bir hata oluştu.'], 500);
        }
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
        try {
            $employe = Employees::findOrFail($id);

            $employe->delete();
            return response()->json(['messages' => 'Çalışan başarıyla silindi.'], 200);
        } catch (\Exception $e) {
            return response()->json(['messages' => 'Beklenmedik bir hata oluştu.'], 500);
        }
    }
}
