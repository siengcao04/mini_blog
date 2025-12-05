<x-guest-layout>
    <div class="auth-header">
        <div class="app-logo">
            <i class="bi bi-journal-text text-primary"></i>
        </div>
        <h2>Đăng nhập</h2>
        <p>Chào mừng bạn quay trở lại!</p>
    </div>

    <div class="auth-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope me-1"></i> Email
                </label>
                <input id="email" type="email" name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-1"></i> Mật khẩu
                </label>
                <input id="password" type="password" name="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    Ghi nhớ đăng nhập
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập
            </button>

            @if (Route::has('password.request'))
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-link">
                        <i class="bi bi-question-circle me-1"></i> Quên mật khẩu?
                    </a>
                </div>
            @endif

            @if (Route::has('register'))
                <div class="text-center mt-2">
                    <span class="text-muted">Chưa có tài khoản?</span>
                    <a href="{{ route('register') }}" class="text-link ms-1">Đăng ký ngay</a>
                </div>
            @endif
        </form>
    </div>
</x-guest-layout>
