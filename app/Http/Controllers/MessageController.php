<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Writer;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employer')->only(['indexForEmployer', 'showForEmployer', 'sendForEmployer', 'startChatForEmployer']);
        $this->middleware('auth:writer')->only(['indexForWriter', 'showForWriter', 'sendForWriter', 'startChatForWriter']);
    }

    public function indexForEmployer()
    {
        $conversations = Conversation::where('employer_id', Auth::guard('employer')->id())
            ->with('writer')
            ->get();
        $writers = Writer::all(); // Get all writers for the select dropdown
        return view('employer.chat-user-list', compact('conversations', 'writers')); // Pass writers to the view
    }

    public function indexForWriter()
    {
        $conversations = Conversation::where('writer_id', Auth::guard('writer')->id())
            ->with('employer')
            ->get();
        $employers = Employer::all(); // Get all employers for the select dropdown
        return view('writer.chat-user-list', compact('conversations', 'employers')); // Pass employers to the view
    }

    public function startChatForEmployer(Request $request)
    {
        $employerId = Auth::guard('employer')->id();
        $writerId = $request->writer_id;

        Log::info("Starting chat for Employer ID: $employerId with Writer ID: $writerId");

        $conversation = Conversation::firstOrCreate([
            'employer_id' => $employerId,
            'writer_id' => $writerId,
        ]);

        return redirect()->route('employer.chat.show', $conversation->id);
    }

    public function startChatForWriter(Request $request)
    {
        $writerId = Auth::guard('writer')->id();
        $employerId = $request->employer_id;

        Log::info("Starting chat for Writer ID: $writerId with Employer ID: $employerId");

        $conversation = Conversation::firstOrCreate([
            'employer_id' => $employerId,
            'writer_id' => $writerId,
        ]);

        return redirect()->route('writer.chat.show', $conversation->id);
    }

    public function showForEmployer(Conversation $conversation)
    {
        $this->authorizeEmployer($conversation);
        $conversation->load('employer', 'writer');
        $messages = $conversation->messages;
        return view('employer.chat-show', compact('conversation', 'messages'));
    }

    public function showForWriter(Conversation $conversation)
    {
        $this->authorizeWriter($conversation);
        $conversation->load('employer', 'writer');
        $messages = $conversation->messages;
        return view('writer.chat-show', compact('conversation', 'messages'));
    }

    public function sendForEmployer(Request $request, Conversation $conversation)
    {
        $this->authorizeEmployer($conversation);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::guard('employer')->id(),
            'sender_type' => 'employer',
            'content' => $request->message,
            'attachment' => $request->file ? $request->file->store('attachments') : null
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return redirect()->back();
    }

    public function sendForWriter(Request $request, Conversation $conversation)
    {
        $this->authorizeWriter($conversation);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::guard('writer')->id(),
            'sender_type' => 'writer',
            'content' => $request->message,
            'attachment' => $request->file ? $request->file->store('attachments') : null
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return redirect()->back();
    }

    private function authorizeEmployer(Conversation $conversation)
    {
        if ($conversation->employer_id !== Auth::guard('employer')->id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function authorizeWriter(Conversation $conversation)
    {
        if ($conversation->writer_id !== Auth::guard('writer')->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
