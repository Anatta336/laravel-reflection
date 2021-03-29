<?php

namespace App\Http\Controllers;

use App\Company;

class EmployeesOfCompany extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        return view('employee.companyEmployees', [
            'company' => $company,
            'employees' => $company->employees()->orderBy('last_name')->paginate(10),
        ]);
    }
}
