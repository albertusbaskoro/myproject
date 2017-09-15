<?php

namespace App\Http\Controllers\Api\V1;


use JWTAuth;
use App\User;
use App\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Messages\MailMessage;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use App\Transformers\RelationTransformer;

class UserController extends Controller
{
    public function toMail($notifiable)
    {
        $url = url('/kotaksarapan/'.$this->invoice->id);

        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('One of your invoices has been paid!')
                    ->line('View Invoice http://password.change.com/?$url')
                    ->line('Thank you for using our application!');

        return response()->json(['status' => true, 'message' => 'check email' ]);
    }

    public function register(Request $request)
    {
        $this->content = array();
    }
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $token =  $user->createToken('Pizzapp')->accessToken;
            $status = 200;
        } else {
            $this->content['error'] = "Unauthorised";
            $status = 401;
        }
        return response()->json($this->content, $status);
    }

    public function details()
    {
        return response()->json(['user' => Auth::user()]);
    }

    public function index()
    {     
        $paginator = User::user()->paginate(request()->input('per_page'));

        $users = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
                        ->collection($users, new UserTransformer(), 'user')
                        ->serializeWith(new JsonApiSerializer(url('/api/')))
                        ->respond();
    }

    public function show(User $user)
    {
        return fractal()->item($user, new UserTransformer(), 'user')
                        ->serializeWith(new JsonApiSerializer(url('/api/')))
                        ->parseIncludes(request()->input('include'))
                        ->respond();
    }
        
}
