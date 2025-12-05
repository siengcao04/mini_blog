@extends('layouts.admin')

@section('title', 'Quản lý Tag - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Tag</h2>
    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tạo tag mới
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th>Tên tag</th>
                    <th>Slug</th>
                    <th style="width: 100px">Số bài viết</th>
                    <th style="width: 150px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td><strong>{{ $tag->name }}</strong></td>
                        <td><code>{{ $tag->slug }}</code></td>
                        <td><span class="badge bg-info">{{ $tag->posts_count }}</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
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
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Chưa có tag nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $tags->links() }}
</div>
@endsection
