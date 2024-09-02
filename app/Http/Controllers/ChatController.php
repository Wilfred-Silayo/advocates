<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function login(Request $request){
        $request->session()->flash('status', 'Please login to chat with us');
        return redirect()->route('login');
    }
    
    public function list()
    {
        $superuser = User::where('role', 'superuser')->first();
        return view('chat.index', compact('superuser'));
    }

    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        $authId = Auth::id();

        // Search for users
        $users = User::where('name', 'like', "%$query%")->where('id', '!=', $authId)
            ->get()
            ->map(function ($user) use ($authId) {
                // Count unread messages for each user
                $unreadCount = Chat::where('receiver_id', $authId)
                    ->where('sender_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'profile_pic' => $user->profile_pic,
                    'unread_count' => $unreadCount,
                ];
            });

        return response()->json($users);
    }


    public function recentChats()
    {
        $authId = Auth::id();

        $receivedMessages = Chat::where('receiver_id', $authId)
            ->pluck('sender_id')
            ->unique();

        $sentMessages = Chat::where('sender_id', $authId)
            ->pluck('receiver_id')
            ->unique();

        $userIds = $receivedMessages->merge($sentMessages)->unique();

        $recentChats = Chat::where(function ($query) use ($authId) {
            $query->where('sender_id', $authId)
                ->orWhere('receiver_id', $authId);
        })
            ->whereIn('sender_id', $userIds)
            ->orWhereIn('receiver_id', $userIds)
            ->latest('created_at')
            ->get()
            ->groupBy(function ($chat) use ($authId) {
                return $chat->sender_id == $authId ? $chat->receiver_id : $chat->sender_id;
            });

        // Prepare the data for the response
        $data = $userIds->map(function ($userId) use ($recentChats, $authId) {
            $user = User::find($userId);
            $recentChat = $recentChats->get($userId)->first();
            $unreadCount = Chat::where('sender_id', $userId)
                ->where('receiver_id', $authId)
                ->where('is_read', false)
                ->count();

            return [
                'id' => $user->id,
                'name' => $user->name,
                'profile_pic' => $user->profile_pic,
                'unread_count' => $unreadCount,
                'last_message' => $recentChat ? $recentChat->message : '',
                'last_message_time' => $recentChat ? $recentChat->created_at->diffForHumans() : '',
            ];
        });

        return response()->json($data);
    }


    public function loadConversation($userId)
    {
        $authId = Auth::id();

        $messages = Chat::where(function ($query) use ($authId, $userId) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $userId);
        })
            ->orWhere(function ($query) use ($authId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $authId);
            })
            ->orderBy('created_at', 'asc')
            ->get();


        Chat::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->update(['is_read' => true]);


        $unreadCount = Chat::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'messages' => $messages,
            'unreadCount' => $unreadCount
        ]);
    }


    public function fetchNewMessages()
    {
        $authId = Auth::id();

        // Get updated badge counts for all users
        $badges = Chat::where('receiver_id', $authId)
            ->where('is_read', false)
            ->select('sender_id as user_id', DB::raw('count(*) as unread_count'))
            ->groupBy('sender_id')
            ->get();

        // Get the latest messages for the currently active chat
        $activeUserId = request()->get('active_user_id');
        $messages = [];
        if ($activeUserId) {
            $messages = Chat::where(function ($query) use ($authId, $activeUserId) {
                $query->where('sender_id', $authId)
                    ->where('receiver_id', $activeUserId);
            })
                ->orWhere(function ($query) use ($authId, $activeUserId) {
                    $query->where('sender_id', $activeUserId)
                        ->where('receiver_id', $authId);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return response()->json([
            'badges' => $badges,
            'messages' => $messages
        ]);
    }


    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:500',
        ]);

        $senderId = Auth::id();

        $chat = new Chat();
        $chat->sender_id = $senderId;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->is_read = false;
        $chat->save();

        return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
    }

    public function deleteConversation(Request $request)
    {
        $userId = Auth::id();
        $receiverId = $request->input('receiver_id');

       

        Chat::where(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $userId);
        })->delete();

        return response()->json(['success' => true]);
    }
}
