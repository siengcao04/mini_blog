<section>
    <h3>
        <i class="bi bi-person-fill"></i> Thông tin cá nhân
    </h3>
    <p>Cập nhật thông tin tài khoản và địa chỉ email của bạn</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-person me-1"></i> Tên
            </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="bi bi-envelope me-1"></i> Email
            </label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-2">
                    <small>Email của bạn chưa được xác thực.</small>
                    <button form="send-verification" class="btn btn-link btn-sm p-0">
                        Gửi lại email xác thực
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <div class="text-success mt-1">
                            <small>Link xác thực mới đã được gửi!</small>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Lưu thay đổi
        </button>

        @if (session('status') === 'profile-updated')
            <span class="text-success ms-2">
                <i class="bi bi-check-circle"></i> Đã lưu!
            </span>
        @endif
    </form>
</section>
