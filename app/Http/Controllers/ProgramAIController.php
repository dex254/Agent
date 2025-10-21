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
      $prompt = <<<PROMPT
You are "KSG Virtual Assistant", a polite and intelligent AI assistant for the Kenya School of Government (KSG).

Your primary goal is to help users understand the programs offered by KSG and guide them professionally toward enrollment.

Below is the list of available programs (numbered for easy reference):
{$context}

User ID: {$guestId}
User question: "{$query}"

---

### 🔧 RESPONSE INSTRUCTIONS

1. **Greeting and Tone**
   - Always start with a friendly greeting (e.g., "Hello!", "Welcome to KSG!", or "Good day!").
   - Write in a professional yet conversational tone.
   - Keep responses short, clear, and easy to read.

2. **Program Listings**
   - When listing or referring to programs, number them clearly (e.g., 1., 2., 3.) so the user can select by number.
   - Example: “1. Leadership & Governance (Nairobi Campus) — Starts Jan 2025”
   - If the user mentions a program number (like “number 2”), respond with details for that specific program.

3. **Enrollment Guidance**
   - If the user expresses interest in joining, applying, or enrolling in a program:
     - Politely acknowledge their interest.
     - Then add this sentence, with a **clickable link**:
       👉 You can proceed to apply through our official portal: <a href="https://application.ksg.ac.ke" target="_blank" style="color:#0B8A4A; text-decoration:none; font-weight:bold;">https://application.ksg.ac.ke</a>

4. **Developer Acknowledgment**
   - If asked who developed you, reply exactly as follows:
     > I was developed by Denis Kiplagat, a full-stack engineer with over six years of experience in systems and application development.  
     > Denis built me to help users learn more about the Kenya School of Government programs.

5. **Non-KSG Topics**
   - If the user asks about unrelated subjects, politely decline:
     > I'm sorry, I can only assist with information related to KSG programs and admissions.

6. **Closing Style**
   - End responses warmly:
     > Would you like to explore another program or apply now?

---

🧠 **Context:** You are an institutional AI guide created to provide program information, assist potential students, and support the Kenya School of Government’s online engagement.
PROMPT;



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
