<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Mail\Registration;
use App\User;
use App\UserProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class AuthenticateController extends Controller
{
    /**
     * Register new account
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'phone' => 'required|max:20',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            // update from existing user
            $user->name = $request->name;
            $user->phone = $request->phone;
            $request->password = bcrypt($request->password);
            $user->save();

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'User exist, data updated please login with email',
                'user' => $user,
                'token' => $token,
            ]);

        } else {

            $user = new User;

            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->imagepath = $request->imagepath;
            $user->verifyToken = str_random(40);

            $user->save();

            Mail::to($user->email)->send(new Registration($user));

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => true,
                'code'  => 200,
                'message' => 'User doesnt exist, Register Successfull',
                'token' => $token,
                'user' => $user,
            ]);
        }
    }

    public function sendEmailDone($email, $verifyToken): JsonResponse
    {
        $user = User::where(['email' => $email, 'verifyToken' => $verifyToken])->first();

        if ($user) {
            User::where(['email' => $email, 'verifyToken' => $verifyToken])->update(['status' => '1', 'verifyToken' => null]);
            return view('activated');
        } else {
            return 'user not found';
        }
    }

    /**
     * Password request
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        // make sure input data is clean
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:user,email',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        if (User::where('email', '=', request()->email)->count() > 0) {

            $user = User::where('email', '=', request()->email)->FirstOrFail();
            Mail::to($user->email)
                ->send(new ForgotPassword($user));

            return response()->json(['status' => true, 'message' => 'Email Sent to ' . request()->email, 'user' => $user], 200);
        }
    }

    /**
     * Manul login using email & password
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:user,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->FirstOrFail();

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'code' => 401,
                    'error' => 'Invalid Username or Password',
                    'links' => [
                        'self' => $request->fullUrl(),
                    ],
                ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'status' => false,
                'code' => 500,
                'error' => $e->getMessage(),
                'links' => [
                    'self' => $request->fullUrl(),
                ],
            ], 500);
        }

        // all good so return the token
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Login Success',
            'user' => $user,
            'token' => $token,
            'links' => [
                'self' => $request->fullUrl(),
            ],
        ]);
    }

    /**
     * Login using provider like Facebook or Google
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function loginProvider(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'provider' => 'required',
            'provider_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        // first, search provider and provider id in database
        $provider = UserProvider::where('provider', $request->name)
            ->where('provider_id', $request->id)
            ->with('user')
            ->first();

        if (User::where('email', '=', request()->email)->count() > 0) {

            $user = User::where('email', '=', request()->email)->FirstOrFail();
            // if doesn't exists, create new one
            if ($userlogin = UserProvider::where('user_id', '=', $user['id'])
                ->where('provider', '=', $request->provider)
                ->count() < 1) {

                $userprovider = new UserProvider;
                $userprovider->user_id = $user->id;
                $userprovider->provider = $request->provider;
                $userprovider->provider_id = $request->provider_id;
                $userprovider->save();

                $token = JWTAuth::fromUser($user);

                return response()->json(['status' => true, 'code' => 200, 'message' => 'Register Success with ' . request()->provider, 'user' => $user, 'user_provider' => $userprovider, 'token' => $token], 200);

            } else {

                $user = User::where('email', '=', request()->email)->FirstOrFail();

                $userlogin = UserProvider::where('user_id', '=', $user['id'])
                    ->where('provider', '=', $request->provider)
                    ->where('provider_id', '=', $request->provider_id)->FirstOrFail();

                $token = JWTAuth::fromUser($user);

                return response()->json(['status' => true, 'code' => 200, 'message' => 'Login Success with ' . request()->provider, 'user' => $user, 'user_provider' => $userlogin, 'token' => $token], 200);

            }

        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $provider = UserProvider::create([
                'user_id' => $user->id,
                'provider' => $request->provider,
                'provider_id' => $request->provider_id,
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => true,
                'code' => 200,
                'user' => $user,
                'user_provider' => $provider,
                'message' => 'Register ' . $request->provider . ' Successfull',
                'token' => $token,
            ]);
        }

    }

    /**
     * Login as public user with existing email
     *
     * @param  Request $request
     * @return JSON
     */
    public function publicLogin(Request $request): JsonResponse
    {
        if ($request->email != config('api.email')) {
            // based on spec at: http://jsonapi.org/format/#errors
            return response()->json([
                'status' => false,
                'code' => 401,
                'title' => 'Unauthorized',
                'detail' => 'Invalid email address.',
                'links' => [
                    'self' => $request->fullUrl(),
                ],
            ], 401);
        }

        $user = User::where('email', $request->email)->FirstOrFail();

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => !empty($token),
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return $this->error('User not found', 204);
            }
        } catch (TokenExpiredException $e) {
            return $this->error('Token Expired', 401);
        } catch (TokenInvalidException $e) {
            return $this->error('Token Invalid', 401);
        } catch (JWTException $e) {
            return $this->error('Token Absent', 400);
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json([
            'error' => 'token_valid',
            'user' => $user,
            'code' => 200,
            'isActive' => true]);
    }

    private function error($message, $statusCode = 401)
    {
        return response()->json([
            'code' => $statusCode,
            'error' => $message,
        ], $statusCode);
    }

    /**
     * Logout programmatically via client.
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        $request->request->add(['email' => 'public.ks@terralab.co']);

        return $this->publicLogin($request);
    }
}
