@extends('layouts.app')
@section('title')
    Chat-bot Gather
@endsection
@php

    $user = DB::table('users')->select('user_image')->where('id', '=', Auth::user()->id)->first();
    $userImage = $user ? $user->user_image : ''; // افتراضي إذا لم يكن هناك رابط صورة

       $menu = 'Chat-bot';
       $rightbarImage = 'notice.png';
@endphp

@section('content')
    <div class="row">
        {{-- Left section started --}}
        <div class="d-none d-lg-block col-lg-3 py-md-4 scroll">
            @include('layouts.includes.leftbar')
        </div>
        {{-- Left section ended --}}

        {{-- Center chat section --}}
        <div class="col-lg-9 col-md-8 col-sm-12 py-md-4 pt-4 scroll">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    background-color: #f3f5f9;
                }
                .chat-container {
                    width: 100%;
                    max-width: 100%;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    background-color: #fff;
                }
                .chat-header {
                    background-color: #724ae8;
                    color: #fff;
                    text-align: center;
                    padding: 10px 0;
                    border-top-left-radius: 10px;
                    border-top-right-radius: 10px;
                }
                .chat-content {
                    padding: 20px;
                    display: flex;
                    flex-direction: column;
                }
                .chat-messages {
                    flex-grow: 1;
                    overflow-y: auto;
                    padding: 10px 0;
                }
                .chat-message {
                    margin: 10px 0;
                    padding: 10px;
                    border-radius: 5px;
                    max-width: 90%;
                    word-wrap: break-word;
                    display: flex;
                    align-items: center;
                }
                .user {
                    background-color: #f1f0f0;
                    align-self: flex-start;
                }
                .bot {
                    background-color: #defaff;
                    align-self: flex-end;
                }
                .user-image,
                .bot-image {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    margin: 0 10px;
                }
                .user-image {
                    background-image: url("{{ asset('images/users') . '/' . $userImage }}");
                    background-size: cover;
                    background-repeat: no-repeat;
                }

                .bot-image {
                    background-image: url("{{ asset('/images/users/bot-image.png') }}");
                    background-size: cover;
                    background-repeat: no-repeat;
                }
                .user-input {
                    display: flex;
                    margin-top: 10px;
                }
                #user-message {
                    flex-grow: 1;
                    padding: 10px;
                    border: none;
                    border-radius: 5px 0 0 5px;
                }
                #send-button {
                    padding: 10px 15px;
                    border: none;
                    background-color: #724ae8;
                    color: #fff;
                    border-radius: 0 5px 5px 0;
                    cursor: pointer;
                }
            </style>
            {{-- Chat container --}}
            <div class="chat-container">
                <div class="chat-header">
                    <h2>Chat-bot Gather</h2>
                </div>
                <div class="chat-content">
                    <div class="chat-messages" id="chat-messages">
                    </div>
                    <div class="user-input">
                        <input type="text" id="user-message" placeholder="Type your message...">
                        <button id="send-button">Send</button>
                    </div>
                </div>
            </div>
            {{-- End of chat container --}}
        </div>
        {{-- Center chat section ended --}}
    </div>
    <script>
        const chatMessages = document.getElementById("chat-messages");
        const userMessageInput = document.getElementById("user-message");
        const sendButton = document.getElementById("send-button");

        const apiKey = "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"; // ضع مفتاح API الخاص بك هنا

        // تابع لإرسال الرسالة
        function sendMessage() {
            const userMessage = userMessageInput.value;
            if (userMessage.trim() === "") return;

            // إضافة رسالة المستخدم إلى واجهة المحادثة
            appendMessage("user", userMessage);

            // إرسال رسالة المستخدم إلى خدمة GPT-3
            getBotReply(userMessage)
                .then(botReply => {
                    // إضافة رد البوت إلى واجهة المحادثة
                    appendMessage("bot", botReply);

                    // مسح حقل إدخال الرسالة بعد الإرسال
                    userMessageInput.value = "";

                    // التمرير إلى أسفل لعرض أحدث الرسائل
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                })
                .catch(error => {
                    console.error("Error getting bot reply:", error);
                });
        }

        sendButton.addEventListener("click", sendMessage);

        userMessageInput.addEventListener("keydown", event => {
            if (event.key === "Enter") {
                event.preventDefault();
                sendMessage();
            }
        });

        async function getBotReply(userMessage) {
            const apiUrl = "https://api.openai.com/v1/chat/completions";
            const data = {
                model: "gpt-3.5-turbo",
                messages: [{ role: "system", content: "You are a helpful assistant." }, { role: "user", content: userMessage }],
            };
            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${apiKey}`,
                },
                body: JSON.stringify(data),
            });

            const responseData = await response.json();
            return responseData.choices[0].message.content.trim();
        }

        function appendMessage(role, content) {
            const messageContainer = document.createElement("div");
            messageContainer.classList.add("chat-message", role);

            const image = document.createElement("div");
            image.classList.add(role === "user" ? "user-image" : "bot-image");

            const messageText = document.createElement("div");
            messageText.textContent = content;

            messageContainer.appendChild(image);
            messageContainer.appendChild(messageText);

            chatMessages.appendChild(messageContainer);
        }


    </script>

<div>
@endsection
