<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller {

    public function register( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'name'             => 'required',
            'email'            => 'required|unique:users,email',
            'phone'            => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone',
            'password'         => 'required|min:8',
            'confirm_password' => 'required_with:password|same:password|min:8',
        ], [
            'confirm_password.min'           => 'Confirm password must be 8 characters or more',
            'confirm_password.same'          => 'Confirm password didn\'t match',
            'confirm_password.required_with' => 'Please input your confirm password',
        ] );

        //validate message send through this
        if ( $validator->fails() ) {
            $jsonData = [
                'errors'  => $validator->errors(),
                'success' => false,
            ];
            return response()->json( $jsonData, 401 );
        } else {

            try {
                $saveData           = New User();
                $saveData->name     = $request->name;
                $saveData->email    = $request->email;
                $saveData->phone    = $request->phone;
                $saveData->password = hash::make( $request->password );
                $FinalSave          = $saveData->save();

                //message
                if ( $FinalSave ) {
                    $jsonData = [
                        'message' => $request->name . ' your account successfully created! Now login to access your dashboard.',
                        'success' => true,
                    ];
                    return response()->json( $jsonData, 200 );
                }

            } catch ( Throwable $th ) {
                $jsonData = [
                    'message' => 'Some Technical Error Occurred!',
                    'success' => true,
                ];
                return response()->json( $jsonData, 500 );
            }
        }

    }

    // user login functionality
    public function login( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'email'    => 'required|exists:users,email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'Input your login email',
            'password.required' => 'Input your login password',
            'password.min'      => 'Your login password must be 8 characters',
            'email.exists'      => 'Invalid email address',
        ] );
        //validate message send through this
        if ( $validator->fails() ) {
            $jsonData = [
                'errors'  => $validator->errors(),
                'success' => false,
            ];
            return response()->json( $jsonData, 401 );
        } else {

            //login token generate steps
            $credentials = request( ['email', 'password'] );
            $token       = Auth::attempt( $credentials );

            if ( !$token ) {
                //if login data didn't match then show this error
                $jsonData = [
                    'errorMsg' => 'Incorrect password!',
                    'success'  => false,
                ];
                return response()->json( $jsonData, 401 );
            } else {
                $user = $request->user(); //eitar dara ei user er shob gula data ana hoise

                if ( $user->role === 'administrator' ) {
                    $tokenData = $user->createToken( 'Personal Access Token', ['do_anything'] ); //ei do anythin ta paisi AuthServiceProvider er boot method er tokensCan theke
                } else {
                    $tokenData = $user->createToken( 'Personal Access Token', ['can_create'] );
                }

                $token        = $tokenData->token;
                $aaccessToken = $tokenData->accessToken;

                $token->expires_at = Carbon::now()->addWeeks( 1 );

                if ( $request->remember_me ) {
                    $token->expires_at = Carbon::now()->addWeeks( 1 );
                }

                //condition gula full-fill hole token ta then save hobe
                $savedToken = $token->save();

                if ( $savedToken ) {

                    $jsonData = [
                        'user'         => $user,
                        'access_token' => $tokenData->accessToken,
                        'token_type'   => 'Bearer',
                        'token_scope'  => $tokenData->token->scopes[0],
                        'expires_at'   => Carbon::parse( $tokenData->token->expires_at )->toDateTimeString(),
                        'success'      => true,
                    ];
                    return response()->json( $jsonData, 200 );

                } else {
                    $jsonData = [
                        'message' => 'Some error occurred!',
                        'success' => false,
                    ];
                    return response()->json( $jsonData, 500 );
                }

            }
        }

    }

    // user logout functionality
    public function logout( Request $request ) {
        /*
        note: onek somoy logout hoy na tokhon nicher command diye project er cache clear kore nilei then kaaj korbe:-
        cmd: php artisan config:cache
        cmd: php artisan cache:clear
        cmd: php artisan view:clear
         */

        $token = $request->user()->token(); //using this line jo codes it will be logout....
        $token->revoke();

        DB::table( 'oauth_access_tokens' )->where( 'id', $token->id )->delete();
        DB::table( 'oauth_refresh_tokens' )->where( 'access_token_id', $token->id )->delete();

        $jsonData = [
            'message' => 'You successfully logged out',
            'success' => true,
        ];
        return response()->json( $jsonData, 200 );

    }

    public function getToken( Request $request ) {

        $tokenId = auth( 'api' )->user();

        $jsonData = [
            'user_data_verify' => $tokenId,
            'message'          => 'You successfully logged out',
            'success'          => true,
        ];
        return response()->json( $jsonData, 200 );

    }

}
