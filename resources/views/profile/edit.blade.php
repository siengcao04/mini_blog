@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<style>
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 15px;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .profile-header h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 600;
    }
    
    .profile-header p {
        margin: 10px 0 0;
        opacity: 0.9;
        font-size: 16px;
    }
    
    .profile-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .profile-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }
    
    .profile-card h3 {
        color: #667eea;
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .profile-card p {
        color: #666;
        margin-bottom: 25px;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 15px;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        outline: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 87, 108, 0.4);
    }
    
    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
    
    .text-danger {
        color: #dc3545;
    }
    
    .delete-warning {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <h1><i class="bi bi-person-circle me-2"></i> Hồ sơ cá nhân</h1>
        <p>Quản lý thông tin tài khoản và bảo mật của bạn</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="profile-card">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="profile-card">
        @include('profile.partials.update-password-form')
    </div>

    <div class="profile-card">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
