<section>
    <h3>
        <i class="bi bi-shield-lock"></i> Đổi mật khẩu
    </h3>
    <p>Đảm bảo tài khoản của bạn sử dụng mật khẩu mạnh để an toàn</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="current_password" class="form-label">
                <i class="bi bi-key me-1"></i> Mật khẩu hiện tại
            </label>
            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                   id="current_password" name="current_password" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="bi bi-lock me-1"></i> Mật khẩu mới
            </label>
            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                   id="password" name="password" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                <i class="bi bi-lock-fill me-1"></i> Xác nhận mật khẩu mới
            </label>
            <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                   id="password_confirmation" name="password_confirmation" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Cập nhật mật khẩu
        </button>

        @if (session('status') === 'password-updated')
            <span class="text-success ms-2">
                <i class="bi bi-check-circle"></i> Đã cập nhật!
            </span>
        @endif
    </form>
</section>
