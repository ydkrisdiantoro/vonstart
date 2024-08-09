<?php

namespace App\Livewire;

use App\Helpers\VcontrolHelper;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ForgetPassword extends Component
{
    #[Validate('nullable|email')] 
    public $email;

    #[Validate('nullable|string|min:6|max:6')] 
    public $token;

    public $data;
    public $count;
    public $user;

    #[Validate('required|string|min:6')]
    public $password;
    #[Validate('required|string|min:6|same:password')]
    public $password_confirmation;

    public $expired;

    public function mount()
    {
        $this->email = Session::get('token_generated_for');
        if($this->email){
            $this->data = (new AuthService)->getToken($this->email);
            $this->token = Session::get('token_submitted');
            if($this->token){
                $this->checkToken();
            }
            $this->refreshCount();
        }
    }

    public function sendToken()
    {
        $getToken = (new AuthService)->makeToken($this->email);
        if($getToken){
            Session::put('token_generated_for', $this->email);
            $this->data = $getToken;
            $this->refreshCount();
            $this->expired = null;
        }
    }

    public function save()
    {
        $this->validate();
        $updated = User::find($this->user['id'])->update([
            'password' => Hash::make($this->password),
        ]);
        if($updated){
            $this->reset('email', 'user', 'password', 'password_confirmation', 'token', 'data', 'count', 'expired');
            Session::flush();
            $alert = VcontrolHelper::returnAlert(true, 'Password changed!');
            return redirect()->route('login.read')->with($alert[0], $alert[1]);
        }
    }

    public function checkToken()
    {
        $check = (new AuthService)->checkOtp($this->token);
        if(@$check->user_id){
            $this->user = User::find($check->user_id)->toArray();
            Session::put('token_submitted', $this->token);
        } else{
            $this->expired = true;
            $this->token = null;
        }
    }

    public function refreshCount()
    {
        if (isset($this->data['expired_at'])) {
            $date = $this->data['expired_at'];
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $date);
            $now = Carbon::now();
            
            if ($now->greaterThan($endDate)) {
                $this->count = '0';
            } else {
                $diff = $endDate->diff($now);
                $this->count = $diff->format('%I:%S');
            }
        } else{
            $this->count = 0;
        }
    }

    public function orLogin()
    {
        Session::forget('token_generated_for');
        $this->expired = null;
        return redirect()->route('login.read');
    }

    public function render()
    {
        return view('livewire.forget-password');
    }
}
