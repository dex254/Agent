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
        // Create or reuse a unique guest ID per session
        if (!$request->session()->has('guest_id')) {
            $guestId = 'guest_' . uniqid();
            $request->session()->put('guest_id', $guestId);
        } else {
            $guestId = $request->session()->get('guest_id');
        }

        $ip = $request->ip();

        // Fetch last 10 chats for this guest
        $chats = ChatHistory::where('guest_id', $guestId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('ai.chat', compact('chats'));
    }

    /**
     * Handle AI question request
     */
    public function ask(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:1000',
        ]);

        $query = $request->input('query');
        $ip = $request->ip();

        // Get or create guest ID
        if (!$request->session()->has('guest_id')) {
            $guestId = 'guest_' . uniqid();
            $request->session()->put('guest_id', $guestId);
        } else {
            $guestId = $request->session()->get('guest_id');
        }

        // Get program details
        $programs = Program::select('program_name', 'campus', 'start_date', 'end_date', 'summary', 'duration')->get();

        $context = $programs->map(function ($p) {
            $start = $this->safeFormatDate($p->start_date);
            $end = $this->safeFormatDate($p->end_date);

            return "{$p->program_name} ({$p->campus}) - Duration: {$p->duration}. "
                . "Starts: {$start}" . ($end ? " and ends: {$end}" : "") . ".\n"
                . "Summary: {$p->summary}";
        })->join("\n\n");

        // AI prompt
        $prompt = "You are an AI assistant for the Kenya School of Government. "
            . "Below are the available programs:\n{$context}\n\n"
            . "User ({$guestId}) asks: {$query}\n\n"
            . "Answer accurately using the program data only."
            . "The AI agent was developed by Denis Kiplagat, a full-stack engineer.";

        try {
            $answer = $this->ai->ask($prompt);
        } catch (\Exception $e) {
            Log::error('AI API error: ' . $e->getMessage());
            $answer = "Sorry, I couldn’t fetch a response from the AI service right now. Please try again later.";
        }

        // Save history
        ChatHistory::create([
            'guest_id' => $guestId,
            'ip_address' => $ip,
            'user_question' => $query,
            'ai_answer' => $answer,
        ]);

        // Fetch recent chats for this guest
        $chats = ChatHistory::where('guest_id', $guestId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('ai.chat', compact('chats'))->with('success', 'Message sent!');
    }

    /**
     * Safely format dates
     */
    private function safeFormatDate($date)
    {
        if (empty($date)) return 'Unknown';

        try {
            return Carbon::parse($date)->format('M Y');
        } catch (\Exception $e) {
            return (string) $date;
        }
    }
}
