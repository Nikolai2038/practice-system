<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\Chat;
use App\Models\ChatType;
use App\Models\File;
use App\Models\Message;
use App\Models\MessageType;
use App\Models\User;
use Illuminate\Http\Request;
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
            $messages = $chat->messages;
            /**
             * @var Message $message
            */
            foreach ($messages as $message)
            {
                $message->chats()->detach($chat);
            }
            $chat->messages()->delete();
            $chat->delete();
        }
        return redirect()->route('chats')->header('Content-Type', 'text/html');
    }

    public function view(Request $request, $chat_id)
    {
        $total_user = Functions::getTotalUser();
        /**
         * @var Chat $chat
        */
        $chat = Chat::findOrFail($chat_id);
        if($total_user->isUserInChat($chat) == false)
        {
            Chat::findOrFail(-1);
        }

        if($request->isMethod('post'))
        {
            $errors = array();

            $message_text = $request->input('message_text');

            if(($message_text != null) || $request->hasFile('uploaded'))
            {
                $message = new Message;
                $message->text = $message_text ?? '';
                $message->message_type()->associate(MessageType::find(MessageType::MESSAGE_TYPE_ID_OTHER));
                $message->user_from()->associate($total_user);
                $message->save();
                $message->chats()->attach($chat);

                $users_in_chat = $chat->users()->where('users.id', '!=', $total_user->id)->get();
                foreach ($users_in_chat as $user)
                {
                    $user_to_chat = $user->chats()->find($chat_id)->user_to_chat;
                    $user_to_chat->messages_not_read++;
                    $user_to_chat->save();
                }

                if($request->hasFile('uploaded'))
                {
                    $files = $request->file('uploaded');
                    foreach ($files as $file)
                    {
                        if ($file->isExecutable())
                        {
                            $errors[] = 'Файл не может быть исполняемым!';
                        }
                        else if ($file->getSize() > 1024 * 1024 * 3)
                        {
                            $errors[] = 'Максимальный размер файла - 3 мб!';
                        }

                        if(count($errors) == 0)
                        {
                            $db_file = File::fileCreate($file, 'files', $total_user);
                            $message->files()->attach($db_file);
                        }
                    }
                }
            }

            $messages = $chat->messages;
            $messages_created_at = array();
            $messages_users = array();
            $messages_users_avatars = array();
            $messages_users_onlines = array();
            $messages_files = array();
            /**
             * @var Message $message
             */
            $i = 0;
            foreach ($messages as $message)
            {
                $messages_created_at[$i] = $message->created_at->toDateTimeString();
                $messages_users[$message->user_from_id] = $message->user_from;
                $messages_users_avatars[$message->user_from_id] = $message->user_from->getAvatarFileSrc();
                $messages_users_onlines[$message->user_from_id] = $message->user_from->isOnline();
                $messages_files[$i] = $message->files;
                $i++;
            }

            $user_to_chat = $total_user->chats()->find($chat->id)->user_to_chat;
            $user_to_chat->messages_not_read = 0;
            $user_to_chat->save();

            return response()
                ->json([
                    'errors' => $errors,
                    'total_user_id' => $total_user->id,
                    'chat_id' => $chat_id,
                    'messages' => $messages,
                    'messages_created_at' => $messages_created_at,
                    'messages_users' => $messages_users,
                    'messages_users_avatars' => $messages_users_avatars,
                    'messages_users_onlines' => $messages_users_onlines,
                    'messages_files' => $messages_files
                ])
                ->header('Content-Type', 'text/html');
        }

        $user_to_chat = $total_user->chats()->find($chat->id)->user_to_chat;
        $user_to_chat->messages_not_read = 0;
        $user_to_chat->save();

        return response()->view('chats.view', [
            'total_user' => $total_user,
            'chat' => $chat
        ])->header('Content-Type', 'text/html');
    }
}
