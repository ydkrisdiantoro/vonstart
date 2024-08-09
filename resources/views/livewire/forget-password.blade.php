<div>
    @if ($expired)
        <div class="alert alert-danger">Token Expired!</div>
    @endif

    @if ($email)
        @if ($user)
            <div class="form-floating">
                <input type="password"
                    wire:model="password"
                    class="form-control"
                    id="password"
                    placeholder="ua673gz"
                    autofocus
                    required>
                <label for="password">New Password</label>
            </div>
            <div class="mb-3 text-start">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-floating">
                <input type="password"
                    wire:model="password_confirmation"
                    class="form-control"
                    id="password_confirmation"
                    placeholder="ua673gz"
                    required>
                <label for="password_confirmation">Retype Password</label>
            </div>
            <div class="mb-3 text-start">
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mx-auto d-flex justify-content-between">
                <a type='button' class="link" wire:click="orLogin">
                    Or Login?
                </a>
                <button class="btn btn-primary" wire:click="save">
                    Change Password
                    <i class="bi bi-box-arrow-in-right"></i>
                </button>
            </div>
        @else
            <p>
                Check your email to get OTP Code ...
                <br>
                @if ($count == 0)
                    <button class="btn btn-sm btn-danger" wire:click="sendToken">
                        Resend OTP
                        <i class="bi bi-box-arrow-up-right"></i>
                    </button>
                @else
                    <span id="countdown" data-end-time="{{ $data['expired_at'] }}">
                        {{ $count }}
                    </span>
                @endif
            </p>
            <div class="form-floating">
                <input type="text"
                    wire:model="token"
                    class="form-control"
                    id="floatingInput"
                    placeholder="000000"
                    autofocus
                    required>
                <label for="floatingInput">Token</label>
            </div>
            <div class="mb-3 text-start">
                @error('token')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mx-auto d-flex justify-content-between">
                <a type='button' class="link" wire:click="orLogin">
                    Or Login?
                </a>
                <button class="btn btn-primary" wire:click="checkToken">
                    Check OTP
                    <i class="bi bi-box-arrow-in-right"></i>
                </button>
            </div>
        @endif
    @else
        <div class="form-floating">
            <input type="email"
                wire:model="email"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
                autofocus
                required>
            <label for="floatingInput">Email Address</label>
        </div>
        <div class="mb-3 text-start">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mx-auto d-flex justify-content-between">
            <a type='button' class="link" wire:click="orLogin">
                Or Login?
            </a>
            <button class="btn btn-primary" wire:click="sendToken">
                Send OTP
                <i class="bi bi-box-arrow-in-right"></i>
            </button>
        </div>
    @endif

    <script>
        function updateCountdown() {
            const countdownElement = document.getElementById('countdown');
            if (!countdownElement) return;
    
            const endDate = new Date(countdownElement.getAttribute('data-end-time'));
            const now = new Date();
            
            const diff = endDate - now;
            if (diff <= 0) {
                countdownElement.innerText = '0:00';
                return;
            }
            
            const minutes = Math.floor(diff / 1000 / 60);
            const seconds = Math.floor((diff / 1000) % 60);
            countdownElement.innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            if (minutes == 0 && seconds == 0) {
                @this.set('count', 0);
            }
        }
        
        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
    
</div>
