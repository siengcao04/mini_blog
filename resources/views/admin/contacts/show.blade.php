@extends('layouts.admin')

@section('title', 'Chi tiết Liên hệ - Admin')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Chi tiết Liên hệ</h2>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $contact->subject }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Người gửi:</strong></p>
                <p>{{ $contact->name }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Email:</strong></p>
                <p><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Ngày gửi:</strong></p>
                <p>{{ $contact->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Trạng thái:</strong></p>
                <p>
                    @if($contact->is_read)
                        <span class="badge bg-secondary">Đã đọc</span>
                    @else
                        <span class="badge bg-primary">Chưa đọc</span>
                    @endif
                </p>
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <p class="mb-1"><strong>Nội dung:</strong></p>
            <div class="border rounded p-3 bg-light">
                {!! nl2br(e($contact->message)) !!}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex gap-2">
            <form action="{{ route('admin.contacts.toggle-read', $contact) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-{{ $contact->is_read ? 'warning' : 'success' }}">
                    <i class="bi bi-{{ $contact->is_read ? 'envelope' : 'envelope-check' }} me-1"></i>
                    {{ $contact->is_read ? 'Đánh dấu chưa đọc' : 'Đánh dấu đã đọc' }}
                </button>
            </form>
            
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" 
                  onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i> Xóa
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
