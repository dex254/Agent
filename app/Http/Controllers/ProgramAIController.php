<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Models\Program;
use App\Models\ChatHistory;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProgramAIController extends Controller
{
    protected $ai;

    public function __construct(OpenAIService $ai)
    {
        $this->ai = $ai;
    }

    /**
     * Display chat history.
     */
    public function index(Request $request)
    {
        $ip = $request->ip();

        $chats = ChatHistory::where('ip_address', $ip)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('ai.chat', compact('chats'));
    }

    /**
     * Handle AI question request.
     */
    public function ask(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:1000',
        ]);

        $query = $request->input('query');
        $ip = $request->ip();

        // ✅ Get program details safely
        $programs = Program::select(
            'program_name',
            'campus',
            'start_date',
            'end_date',
            'summary',
            'duration'
        )->get();

        // ✅ Build a safe context (no format() on raw strings)
        $context = $programs->map(function ($p) {
            $start = $this->safeFormatDate($p->start_date);
            $end = $this->safeFormatDate($p->end_date);

            return "{$p->program_name} ({$p->campus}) - Duration: {$p->duration}. "
                . "Starts: {$start}" . ($end ? " and ends: {$end}" : "") . ".\n"
                . "Summary: {$p->summary}";
        })->join("\n\n");

        // ✅ AI prompt
        $prompt = "You are an assistant for Kenya School of Government. "
                . "Below is a list of current and upcoming programs:\n{$context}\n\n"
                . "User question: {$query}\n\n"
                . "Answer the question clearly and accurately using only the given program information."
                . "You are an AI assistant designed and trained by **Denis**, 
a Full Stack Developer with over 6 years of experience in systems development.

You assist users in learning about Kenya School of Government’s ongoing and upcoming programs.

Below is a list of the programs.";

        try {
            $answer = $this->ai->ask($prompt);
        } catch (\Exception $e) {
            Log::error('AI API error: ' . $e->getMessage());
            $answer = "Sorry, I couldn’t fetch a response from the AI service right now. Please try again later.";
        }

        // ✅ Save history
        ChatHistory::create([
            'ip_address' => $ip,
            'user_question' => $query,
            'ai_answer' => $answer,
        ]);

        // ✅ Reload updated chats
        $chats = ChatHistory::where('ip_address', $ip)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('ai.chat', compact('chats'))->with('success', 'Message sent!');
    }

    /**
     * Safely format a date (handles nulls and strings).
     */
    private function safeFormatDate($date)
    {
        if (empty($date)) {
            return 'Unknown';
        }

        try {
            return Carbon::parse($date)->format('M Y');
        } catch (\Exception $e) {
            return (string) $date; // fallback to raw string if invalid format
        }
    }
}
