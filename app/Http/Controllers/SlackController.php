<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SlackController extends Controller
{
    public function redirectToSlack(){
        return Socialite::driver('slack')->redirect('');
    }

    public function handleSlackCallback(){

        try {
            $user = Socialite::driver('slack')->user();
            $findUser = User::where('slack_id', $user->id)->first();

            if($findUser){
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            }else{
                $newUser = User::updateOrCreate([
                    'email' => $user->email,
                    'name' => $user->name,
                    'slack_id' => $user->id,
                    //'password' => encrypt('dummy12345'),
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
        }
        }catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
