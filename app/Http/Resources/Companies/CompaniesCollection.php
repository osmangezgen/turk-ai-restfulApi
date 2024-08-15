<?php

namespace App\Http\Resources\Companies;

use App\Http\Resources\Employees\EmployeesCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompaniesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(function ($company) {
                return new CompaniesResource($company);
            }),
        ];
    }
}
