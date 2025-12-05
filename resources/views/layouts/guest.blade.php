<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            .auth-card {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                overflow: hidden;
                max-width: 450px;
                margin: 50px auto;
            }
            
            .auth-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 40px 30px;
                text-align: center;
            }
            
            .auth-header h2 {
                margin: 0;
                font-weight: 600;
                font-size: 28px;
            }
            
            .auth-header p {
                margin: 10px 0 0;
                opacity: 0.9;
                font-size: 14px;
            }
            
            .auth-body {
                padding: 40px 30px;
            }
            
            .form-label {
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
            }
            
            .form-control {
                border: 2px solid #e0e0e0;
                border-radius: 10px;
                padding: 12px 15px;
                font-size: 15px;
                transition: all 0.3s ease;
            }
            
            .form-control:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            }
            
            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                border-radius: 10px;
                padding: 12px 30px;
                font-weight: 600;
                font-size: 16px;
                transition: all 0.3s ease;
                width: 100%;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            }
            
            .form-check-input:checked {
                background-color: #667eea;
                border-color: #667eea;
            }
            
            .text-link {
                color: #667eea;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            
            .text-link:hover {
                color: #764ba2;
                text-decoration: underline;
            }
            
            .alert {
                border-radius: 10px;
                border: none;
            }
            
            .invalid-feedback {
                font-size: 13px;
            }
            
            .app-logo {
                width: 80px;
                height: 80px;
                background: white;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 36px;
                margin-bottom: 20px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
