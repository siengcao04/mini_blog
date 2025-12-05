<x-guest-layout>
    <div class="auth-header">
        <div class="app-logo">
            <i class="bi bi-person-plus text-primary"></i>
        </div>
        <h2>Đăng ký</h2>
        <p>Tạo tài khoản mới để bắt đầu</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="bi bi-person me-1"></i> Tên
                </label>
                <input id="name" type="text" name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope me-1"></i> Email
                </label>
                <input id="email" type="email" name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" required autocomplete="username">
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
                       required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-lock-fill me-1"></i> Xác nhận mật khẩu
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" 
                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                       required autocomplete="new-password">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i> Đăng ký
            </button>

            <div class="text-center mt-3">
                <span class="text-muted">Đã có tài khoản?</span>
                <a href="{{ route('login') }}" class="text-link ms-1">Đăng nhập ngay</a>
            </div>
        </form>
    </div>
</x-guest-layout>
