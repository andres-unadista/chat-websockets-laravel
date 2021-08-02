<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/chat.css">
    <title>Chat</title>
</head>

<body>
    <section class="msger">
        <div style="display: block;">
            <a href="{{ URL::previous() }}" style="padding: 1em; font-size: 20px;">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </a>
        </div>
        <header class="msger-header">
            <div class="msger-header-title">
                <i class="fas fa-comment-alt"></i> SimpleChat
                <span class="chatWith mx-2 "></span>
                <span class="typing" style="display: none;"> está escribiendo</span>
            </div>

            <div class="msger-header-options">
                <span class="chatStatus offline"><i class="fa fa-cog" aria-hidden="true"></i></span>
            </div>
        </header>

        <main class="msger-chat">

        </main>

        <form class="msger-inputarea">
            <input type="text" class="msger-input" oninput="sendTypingEvent()" placeholder="Enter your message...">
            <input type="hidden" name="text" id="chatImage" value="{{Auth::user()->image}}">
            <button type="submit" class="msger-send-btn">Send</button>
        </form>
    </section>
    <script src='https://use.fontawesome.com/releases/v5.0.13/js/all.js'></script>
    <script src="/js/app.js"></script>
    <script src="/js/chat.js"></script>
</body>

</html>
