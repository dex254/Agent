<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs Assistant - AI Chat</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root{
            --royal-green: #0B8A4A;
            --dull-brown:  #7B5E4A;
            --bg: #f7f6f4;
            --muted: #6b6b6b;
            --chat-max-width: 900px;
            --border-radius: 14px;
            --glass: rgba(255,255,255,0.85);
            --shadow: 0 6px 20px rgba(11, 138, 74, 0.08);
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: var(--bg);
        }

        .ai-chat-wrap {
            background: linear-gradient(180deg, rgba(11,138,74,0.03) 0%, rgba(123,94,74,0.03) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .chat-card {
            width: 100%;
            max-width: var(--chat-max-width);
            background: var(--glass);
            border-radius: 18px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(11,138,74,0.06);
            overflow: hidden;
            display: grid;
            grid-template-rows: auto 1fr auto;
        }

        .chat-header {
            display:flex;
            align-items:center;
            gap:12px;
            padding: 18px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            background: linear-gradient(90deg, rgba(11,138,74,0.06), rgba(123,94,74,0.04));
        }
        .brand {
            width:52px;
            height:52px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            color:white;
            background: linear-gradient(135deg,var(--royal-green), var(--dull-brown));
            box-shadow: 0 4px 14px rgba(11,138,74,0.12);
        }
        .header-title { font-size:18px; font-weight:600; color:#1b1b1b; }
        .header-sub { font-size:13px; color:var(--muted); }

        #chat-box {
            padding: 18px;
            height: 60vh;
            overflow-y: auto;
            background: linear-gradient(180deg, rgba(255,255,255,0.6), rgba(255,255,255,0.4));
        }

        .messages { display:flex; flex-direction:column; gap:14px; max-width:800px; margin:0 auto; }
        .msg { display:flex; gap:12px; align-items:flex-end; max-width:80%; }
        .msg.user { margin-left:auto; flex-direction:row-reverse; }
        .msg.user .bubble {
            background: linear-gradient(135deg, rgba(11,138,74,0.95), rgba(11,138,74,0.85));
            color:white;
            border-bottom-right-radius:6px;
            border-bottom-left-radius:12px;
        }
        .msg.user .avatar {
            width:36px; height:36px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            color:white; background:var(--royal-green); font-weight:700;
        }
        .msg.ai .bubble {
            background:#fff; border:1px solid rgba(0,0,0,0.04); color:#222;
        }
        .msg.ai .avatar {
            width:36px; height:36px; border-radius:6px;
            background: linear-gradient(90deg,var(--dull-brown), rgba(123,94,74,0.9));
            display:flex; align-items:center; justify-content:center;
            color:white; font-weight:700;
        }

        .bubble {
            padding:12px 14px;
            border-radius:12px;
            line-height:1.45;
            font-size:15px;
            box-shadow:0 4px 10px rgba(0,0,0,0.03);
        }
        .meta { margin-top:8px; font-size:12px; color:var(--muted); }

        .chat-input {
            padding:14px;
            border-top:1px solid rgba(0,0,0,0.04);
            background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(255,255,255,0.95));
        }
        .input-row {
            display:flex; gap:10px; align-items:center; max-width:100%;
        }
        .input-row .form-control {
            flex:1; padding:12px 14px; border-radius:10px;
            border:1px solid rgba(11,138,74,0.12);
            outline:none; font-size:14px;
        }
        .input-row .form-control:focus {
            box-shadow:0 6px 18px rgba(11,138,74,0.08);
            border-color:var(--royal-green);
        }
        .btn-send {
            background: linear-gradient(135deg,var(--royal-green), var(--dull-brown));
            color:white; border:none; padding:10px 16px;
            border-radius:10px; font-weight:600; cursor:pointer;
            display:inline-flex; gap:8px; align-items:center;
        }
        .small-note { margin-top:8px; font-size:12px; color:var(--muted); text-align:center; }

        #chat-box::-webkit-scrollbar { width:10px; }
        #chat-box::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(11,138,74,0.22), rgba(123,94,74,0.2));
            border-radius:10px;
        }

        @keyframes pop {
            from { transform: scale(.98); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .bubble { animation: pop .12s ease-out; }
    </style>
</head>
<body>
<div class="ai-chat-wrap">
    <div class="chat-card">
        <header class="chat-header">
            <div class="brand">KS</div>
            <div>
                <div class="header-title">Programs Assistant</div>
                <div class="header-sub">Ask about our programs — powered by AI</div>
            </div>
            <div style="margin-left:auto; text-align:right;">
                <div style="font-size:12px; color:var(--muted)">Connected</div>
                <div style="font-size:12px; color:var(--muted)">
                    {{ request()->ip() }}
                </div>
            </div>
        </header>

        <main id="chat-box">
            <div class="messages" id="messages">
                @forelse($chats->reverse() as $chat)
                    <div class="msg user">
                        <div class="avatar">
                            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'G' }}
                        </div>
                        <div>
                            <div class="bubble">
                                <strong>{{ Auth::check() ? Auth::user()->name : 'Guest' }}:</strong> {{ $chat->user_question }}
                                <div class="meta">{{ $chat->created_at->format('d M Y, H:i') }}</div>
                            </div>

                            <div class="bubble" style="margin-top:6px;">
                                <strong>AI:</strong> {!! nl2br(e($chat->ai_answer)) !!}
                                <div class="meta">Responded {{ $chat->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; color:var(--muted); margin-top:40px;">
                        <div style="font-weight:600;">No chats yet</div>
                        <div style="color:var(--muted); margin-top:6px;">
                            Start by typing a question about our programs below.
                        </div>
                    </div>
                @endforelse
            </div>
        </main>

        <div class="chat-input">
            <form action="{{ route('ai.chat.ask') }}" method="POST" id="chat-form" autocomplete="off">
                @csrf
                <div class="input-row">
                    <input id="query" type="text" name="query" class="form-control"
                        placeholder="Type your question about programs (e.g., 'Which programs start next month?')"
                        required>
                    <button id="sendBtn" class="btn-send" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                            viewBox="0 0 24 24">
                            <path d="M3 11.5L21 3l-9.5 18L11 13.5 3 11.5z" fill="currentColor" />
                        </svg>
                        <span>Send</span>
                    </button>
                </div>
                <div class="small-note">
                    {{ Auth::check() ? 'Logged in as ' . Auth::user()->name : 'You are chatting as a guest.' }}
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    const form = document.getElementById('chat-form');
    const sendBtn = document.getElementById('sendBtn');

    function scrollToBottom() {
        setTimeout(() => chatBox.scrollTop = chatBox.scrollHeight, 100);
    }
    document.addEventListener('DOMContentLoaded', scrollToBottom);

    form.addEventListener('submit', () => {
        sendBtn.disabled = true;
        sendBtn.querySelector('span').textContent = 'Sending...';
        setTimeout(() => {
            sendBtn.disabled = false;
            sendBtn.querySelector('span').textContent = 'Send';
        }, 3000);
    });
</script>
</body>
</html>
