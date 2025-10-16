<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs Assistant - AI Chat</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --royal-green: #0B8A4A;
            --dull-brown: #7B5E4A;
            --neon-green: #00FF88;
            --bg: #f8f7f5;
            --muted: #6b6b6b;
            --chat-max-width: 900px;
            --bubble-radius: 16px;
        }

        body {
            margin: 0;
            font-family: "Inter", system-ui, sans-serif;
            background: var(--bg);
        }

        .ai-chat-wrap {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 32px;
            background: linear-gradient(135deg, rgba(11,138,74,0.04), rgba(123,94,74,0.04));
        }

        .chat-card {
            width: 100%;
            max-width: var(--chat-max-width);
            background: white;
            border-radius: 20px;
            box-shadow: 0 6px 24px rgba(11,138,74,0.12);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            display: flex;
            align-items: center;
            gap: 14px;
            background: linear-gradient(90deg, var(--royal-green), var(--dull-brown));
            color: white;
            padding: 18px 22px;
        }

        .chat-header .brand {
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 1px;
        }

        #chat-box {
            flex: 1;
            overflow-y: auto;
            padding: 22px;
            background: linear-gradient(180deg, #ffffff 0%, #fdfcfb 100%);
        }

        .messages {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* User message (left side) */
        .msg.user {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            animation: fadeIn .3s ease-in;
        }

        .msg.user .bubble {
            background: var(--royal-green);
            color: white;
            border-radius: var(--bubble-radius) var(--bubble-radius) var(--bubble-radius) 6px;
        }

        /* AI message (right side) */
        .msg.ai {
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            gap: 10px;
            animation: fadeIn .3s ease-in;
        }

        .msg.ai .bubble {
            background: var(--dull-brown);
            color: #fff;
            border-radius: var(--bubble-radius) var(--bubble-radius) 6px var(--bubble-radius);
        }

        .bubble {
            padding: 12px 16px;
            font-size: 15px;
            line-height: 1.5;
            max-width: 70%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .meta {
            margin-top: 6px;
            font-size: 12px;
            color: var(--muted);
        }

        /* Avatar */
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(0,0,0,0.1);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .avatar.user {
            background: var(--royal-green);
        }

        .avatar.ai {
            background: var(--dull-brown);
        }

        /* Input area */
        .chat-input {
            border-top: 1px solid rgba(0,0,0,0.08);
            background: #fff;
            padding: 14px;
        }

        .input-row {
            display: flex;
            gap: 10px;
        }

        .form-control {
            flex: 1;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid rgba(11,138,74,0.2);
            outline: none;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--royal-green);
            box-shadow: 0 0 8px rgba(11,138,74,0.1);
        }

        .btn-send {
            background: linear-gradient(135deg, var(--royal-green), var(--dull-brown));
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Thinking animation */
        .thinking {
            display: inline-flex;
            gap: 5px;
            align-items: center;
        }
        .thinking span {
            width: 6px;
            height: 6px;
            background: var(--neon-green);
            border-radius: 50%;
            animation: blink 1.4s infinite ease-in-out;
        }
        .thinking span:nth-child(2) {
            animation-delay: 0.2s;
        }
        .thinking span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes blink {
            0%, 80%, 100% { opacity: 0; transform: scale(0.8); }
            40% { opacity: 1; transform: scale(1.2); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #chat-box::-webkit-scrollbar {
            width: 10px;
        }
        #chat-box::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(11,138,74,0.3), rgba(123,94,74,0.3));
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="ai-chat-wrap">
    <div class="chat-card">
        <header class="chat-header">
            <div class="brand">KSG AI</div>
            <div style="font-size:13px; color:#e8f8f1;">Ask about our programs — powered by Denis (Full Stack Dev)</div>
        </header>

        <main id="chat-box">
            <div class="messages" id="messages">
                @forelse($chats->reverse() as $chat)
                    <div class="msg user">
                        <div class="avatar user">
                            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'G' }}
                        </div>
                        <div>
                            <div class="bubble">
                                {{ Auth::check() ? Auth::user()->name : 'Guest' }}: {{ $chat->user_question }}
                                <div class="meta">{{ $chat->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="msg ai">
                        <div>
                            <div class="bubble">
                                {!! nl2br(e($chat->ai_answer)) !!}
                                <div class="meta">AI Response • {{ $chat->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="avatar ai">AI</div>
                    </div>
                @empty
                    <div style="text-align:center; color:var(--muted); margin-top:40px;">
                        <strong>No chats yet.</strong><br>
                        Type your first question about our programs below.
                    </div>
                @endforelse
            </div>
        </main>

        <div class="chat-input">
            <form action="{{ route('ai.chat.ask') }}" method="POST" id="chat-form" autocomplete="off">
                @csrf
                <div class="input-row">
                    <input id="query" type="text" name="query" class="form-control"
                        placeholder="Type your question about our programs..."
                        required>
                    <button id="sendBtn" class="btn-send" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                            viewBox="0 0 24 24">
                            <path d="M3 11.5L21 3l-9.5 18L11 13.5 3 11.5z" fill="currentColor" />
                        </svg>
                        <span>Send</span>
                    </button>
                </div>
                <div class="meta" style="text-align:center; margin-top:6px;">
                    {{ Auth::check() ? 'Logged in as ' . Auth::user()->name : 'Chatting as Guest' }}
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    const form = document.getElementById('chat-form');
    const sendBtn = document.getElementById('sendBtn');
    const messages = document.getElementById('messages');

    function scrollToBottom() {
        setTimeout(() => chatBox.scrollTop = chatBox.scrollHeight, 100);
    }

    document.addEventListener('DOMContentLoaded', scrollToBottom);

    // Add thinking animation before AI responds
    form.addEventListener('submit', (e) => {
        sendBtn.disabled = true;
        sendBtn.querySelector('span').textContent = 'Sending...';

        const thinking = document.createElement('div');
        thinking.classList.add('msg', 'ai');
        thinking.innerHTML = `
            <div>
                <div class="bubble">
                    <div class="thinking">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="meta">AI is thinking...</div>
                </div>
            </div>
            <div class="avatar ai">AI</div>
        `;
        messages.appendChild(thinking);
        scrollToBottom();
    });
</script>
</body>
</html>
