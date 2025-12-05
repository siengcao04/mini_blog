@extends('layouts.admin')

@section('title', 'Quản lý Liên hệ - Admin')

@section('content')
<div class="mb-4">
    <h2>Quản lý Liên hệ</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Chủ đề</th>
                    <th style="width: 100px">Trạng thái</th>
                    <th style="width: 120px">Ngày gửi</th>
                    <th style="width: 180px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr class="{{ !$contact->is_read ? 'table-primary' : '' }}">
                        <td>{{ $contact->id }}</td>
                        <td><strong>{{ $contact->name }}</strong></td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ Str::limit($contact->subject, 40) }}</td>
                        <td>
                            @if($contact->is_read)
                                <span class="badge bg-secondary">Đã đọc</span>
                            @else
                                <span class="badge bg-primary">Chưa đọc</span>
                            @endif
                        </td>
                        <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-info" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('admin.contacts.toggle-read', $contact) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $contact->is_read ? 'warning' : 'success' }}" 
                                            title="{{ $contact->is_read ? 'Đánh dấu chưa đọc' : 'Đánh dấu đã đọc' }}">
                                        <i class="bi bi-{{ $contact->is_read ? 'envelope' : 'envelope-check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Chưa có liên hệ nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $contacts->links() }}
</div>
@endsection
