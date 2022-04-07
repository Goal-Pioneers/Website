<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    use Validator;
    
    use App\Http\Requests\AccountRegisterRequest;
    use App\Http\Requests\AccountLoginRequest;

    use App\Models\AccountModel;
    use App\Models\MailingListsModel;

    /**
     * 
     */
    class AccountController 
        extends Controller
    {
        /**
         * 
         */
        final public function register( AccountRegisterRequest $request )
        {
            self::logClientIP( $request );

            $emailInput[ 'content' ] = $request->input( 'mail' );
            
            // does it already exist ?
            $email_exists = false;

            if( !$email_exists )
            {
                $mailModel = MailingListsModel::create( $emailInput );
            }


            $inputModel[ 'username' ] = $request->input( 'username' );
            $inputModel[ 'email_id' ] = $mailModel->id;
            $inputModel[ 'password' ] = Hash::make( $request->input('password') );

            $account = AccountModel::create( $inputModel );

            $token = $account->createToken('account')->plainTextToken;
            $account->remember_token = $token;
            $account->save();

            $outputMessage['token']     = $token;
            $outputMessage['username']  = $account->username;
            $outputMessage['id']        = $account->id;

            return response()->json($outputMessage, 200);
        }


        /**
         * 
         */
        final public function me( Request $request )
        {
            self::logClientIP( $request );
            
            $account = AccountModel::where( 'remember_token', $request->bearerToken() )->firstOrFail();

            $json_response = array();

            $json_response['id'] = $account->id;
            $json_response['username'] = $account->username;

            $json_response['created_at'] = $account->created_at;
            $json_response['updated_at'] = $account->updated_at;

            return response()->json( $json_response, 200 );
        }
        

        /**
         * 
         */
        final public function login( AccountLoginRequest $request )
        {
            self::logClientIP( $request );

            $outputMessage = null;

            if( Auth::attempt( ['username' => $request->username, 'password' => $request->password] ) )
            { 
                $authUser = Auth::user();
                
                $authUser->remember_token = $authUser->createToken( 'account' )->plainTextToken;
                $authUser->save();

                $outputMessage['id']        =  $authUser->id;
                $outputMessage['username']  =  $authUser->username;
                $outputMessage['token']     =  $authUser->remember_token; 
            } 
            else
            { 
                return response()->json( 'Unauthorised.', [ 'error'=>'Unauthorised' ] );
            } 
            
            return response()->json($outputMessage, 200);
        }
    }
?>