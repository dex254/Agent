<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    //
    public function program(Request $request)
    {
        // ✅ Ensure the agent is authenticated
        $agent = Auth::guard('agent')->user();

        if (!$agent) {
            return redirect()->route('agent')->with('error', 'Please log in first.');
        }
        //   $programs = Program::orderBy('created_at', 'desc')->get();

        // ✅ Pass authenticated agent to the dashboard view
        return view('Program.Add', compact('agent'));
    }
    public function postprogram(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'program_code' => 'required|string|max:100|unique:programs,program_code',
            'campus' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount' => 'required|numeric|min:0',
            'created_by' => 'nullable|string',
        ]);

        // Calculate duration
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $diff = $start->diff($end);
        $duration = $diff->format('%m months %d days');

        // Generate summary
        $summary = "Program: {$request->program_name}, Code: {$request->program_code}, " .
                   "Campus: {$request->campus}, Start: {$request->start_date}, End: {$request->end_date}, " .
                   "Duration: {$duration}, Fee: KES {$request->amount}.";

        // Save the record
        Program::create([
            'program_name' => $request->program_name,
            'program_code' => $request->program_code,
            'campus' => $request->campus,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $duration,
            'amount' => $request->amount,
            'summary' => $summary,
            'status' => 'Ongoing',
            'action' => 'Active',
            'created_by' => $request->created_by ?? Auth::guard('agent')->user()->securitykey,
        ]);

        return redirect()->back()->with('success', 'Program added successfully and marked as Ongoing.');
    }

}
