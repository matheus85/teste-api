<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Exception;
use Log;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'email'    => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Request failed.', $validator->messages(), null, 400);
        }

        if (!Auth::attempt([ 'email' => $input['email'], 'password' => $input['password'] ])) {
            return $this->sendError('Unauthorized', null, null, 401);
        }

        $user = auth()->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return $this->sendOk(
            'Autenticação realizada com sucesso',
            [
                'access_token' => $tokenResult->accessToken,
                'token_type'   => 'Bearer',
                'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                'user'         => [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email']
                ]
            ]
        );
    }

    public function signup(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|max:255'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Request failed.', $validator->messages(), null, 400);
        }

        $input['password'] = bcrypt($input['password']);
        $input['email_verified_at'] = Carbon::now();

        DB::beginTransaction();
        try {
            $user = User::create($input);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->sendError('Request failed!', null, null, 400);
        }
        DB::commit();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return $this->sendOk('Cadastro realizado com sucesso.');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendOk('Logout efetuado com sucesso.');
    }
}
