<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class RankingController extends Controller
{
    public function index(Request $request)
{
    $selectedCl = $request->input('cl', 'CL01');

    $ranking = Student::where('cell_group', $selectedCl)
        ->withCount(['attendances' => function ($query) {
            $query->where('is_present', true);
        }])
        ->orderBy('attendances_count', 'desc')
        ->get();

    return view('ranking.cl', compact('ranking', 'selectedCl'));
}
}
