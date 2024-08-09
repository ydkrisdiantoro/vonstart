
@extends('layouts.vcontrol_index')

@section('title')
    {{ $title }}
@endsection

@section('extra-css')
{{--  --}}
@livewireStyles
@endsection

@section('body')

<div id="loginPage">
    <div class="card shadow border-0">
        <div class="card-body text-center px-3 py-5 p-sm-5">
            <h4>Reset Password</h4>

            @livewire('forget-password')

            {{-- @if (@$session['forgot_password'])
                <p class="mb-0">Check your email to get OTP Code ...</p>
                <span id="countdown"></span>
                <form method="POST" action="{{ route('send_otp') }}" class="mb-3" id="resendOtpButton">
                    @csrf
                    <input type="hidden" name="email" value="{{ $session['forgot_password']['email'] }}">
                    <button type="submit" class="btn btn-sm btn-danger">
                        Resend OTP
                        <i class="bi bi-box-arrow-in-right"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('check_otp') }}">
                    @csrf
                    <div class="form-floating">
                        <input type="string"
                            name="otp"
                            class="form-control"
                            id="floatingInput"
                            placeholder="OTP"
                            autofocus>
                        <label for="floatingInput">OTP Code</label>
                    </div>
                    <div class="mb-3 text-start">
                        @error('otp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mx-auto d-flex justify-content-between">
                        <a class="link" href="{{ route('login.read') }}">
                            Or Login?
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Check OTP
                            <i class="bi bi-check-square"></i>
                        </button>
                    </div>
                </form>
            @else
                <form method="POST" action="{{ route('send_otp') }}">
                    @csrf
                    <div class="form-floating">
                        <input type="email"
                            name="email"
                            class="form-control"
                            id="floatingInput"
                            placeholder="name@example.com"
                            autofocus>
                        <label for="floatingInput">Email Address</label>
                    </div>
                    <div class="mb-3 text-start">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mx-auto d-flex justify-content-between">
                        <a class="link" href="{{ route('login.read') }}">
                            Or Login?
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Send OTP
                            <i class="bi bi-box-arrow-in-right"></i>
                        </button>
                    </div>
                </form>
            @endif --}}
        </div>
    </div>
</div>

@endsection

@section('extra-js')
    @livewireScripts
    @if (@$session['forgot_password'])
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                // Mengambil expired_at dari Blade dan mengubahnya menjadi format JavaScript Date
                const expiredAt = new Date("{{ $expired_at }}"); // Pastikan $expired_at adalah string dalam format 'Y-m-d H:i:s'
                
                const countdownElement = document.getElementById('countdown');
                const resendOtpButton = document.getElementById('resendOtpButton');
                resendOtpButton.style.display = 'none';

                function updateCountdown() {
                    const now = new Date();
                    const timeRemaining = expiredAt - now;

                    if (timeRemaining <= 0) {
                        clearInterval(countdownInterval);
                        countdownElement.textContent = "";
                        resendOtpButton.style.display = 'block'; // Menampilkan tombol "Resend OTP"
                    } else {
                        const minutes = Math.floor(timeRemaining / 1000 / 60);
                        const seconds = Math.floor((timeRemaining / 1000) % 60);
                        countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    }
                }

                // Update countdown setiap detik
                const countdownInterval = setInterval(updateCountdown, 1000);

                // Inisialisasi tampilan countdown
                updateCountdown();
            });
        </script>
    @endif
@endsection
