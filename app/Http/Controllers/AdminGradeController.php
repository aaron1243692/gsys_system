<?php

namespace App\Http\Controllers;

use App\Services\GradeReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminGradeController extends Controller
{
    public function index(Request $request, GradeReport $report)
    {

        return view('report.grades.grades', $report->data($request));
    }
}
