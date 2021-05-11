<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\Chat;
use App\Models\ChatType;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class ChatsController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        $chats = $total_user->getPersonalChats();
        $chats_users = $total_user->getPersonalChatsUsers();
        return response()->view('chats.index', ['total_user' => $total_user, 'chats' => $chats, 'chats_users' => $chats_users])->header('Content-Type', 'text/html');
    }

    public function create($with_user_id)
    {
        $total_user = Functions::getTotalUser();
        $watching_user = User::findOrFail($with_user_id);
        $chat = $total_user->getPersonalChatWith($watching_user);
        if($chat == null) // если личного чата между пользователями не существует
        {
            $chat = new Chat;
            $chat->chat_type()->associate(ChatType::find(ChatType::CHAT_TYPE_ID_PERSONAL));
            $chat->save();
            $chat->users()->attach($total_user);
            $chat->users()->attach($watching_user);
            $chat->save();
        }
        return redirect()->route('chats_view', $chat->id)->header('Content-Type', 'text/html');
    }

    public function delete($with_user_id)
    {
        $total_user = Functions::getTotalUser();
        $watching_user = User::findOrFail($with_user_id);
        $chat = $total_user->getPersonalChatWith($watching_user);
        if($chat != null) // если личного чата между пользователями не существует
        {
            $chat->users()->detach($total_user);
            $chat->users()->detach($watching_user);
            $chat->delete();
        }
        return redirect()->route('chats')->header('Content-Type', 'text/html');
    }

    public function view($chat_id)
    {
        $total_user = Functions::getTotalUser();
        $chat = Chat::find($chat_id);
        return response()->view('chats.view', ['total_user' => $total_user, 'chat' => $chat])->header('Content-Type', 'text/html');
    }
}
