@extends('layouts.employer')

@section('content')
    <div class="container">
        <h2>Chat with {{ $conversation->writer->name }}</h2>
        <div class="messages" id="messages">
            @foreach ($messages as $message)
                <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                    <p>{{ $message->content }}</p>
                    @if ($message->attachment)
                        <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">Attached File</a>
                    @endif
                </div>
            @endforeach
        </div>
        <form id="chat-form" action="{{ route('employer.chat.send', $conversation->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <textarea name="message" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="file" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        const conversationId = {{ $conversation->id }};

        Echo.channel('chat.' + conversationId)
            .listen('MessageSent', (event) => {
                const messageHtml = `
                    <div class="message ${event.sender_id === {{ Auth::id() }} ? 'sent' : 'received'}">
                        <p>${event.message}</p>
                        ${event.file ? `<a href="/storage/${event.file}" target="_blank">Attached File</a>` : ''}
                    </div>
                `;
                document.getElementById('messages').innerHTML += messageHtml;
            });

        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    this.reset(); // Clear the form
                }
            });
        });
    </script>
@endsection
