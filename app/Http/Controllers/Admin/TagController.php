<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:tags,name',
        ], [
            'name.required' => 'Tên tag không được để trống.',
            'name.max' => 'Tên tag không được vượt quá :max ký tự.',
            'name.unique' => 'Tag đã tồn tại.',
        ]);

        Tag::create($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được tạo.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:tags,name,' . $tag->id,
        ], [
            'name.required' => 'Tên tag không được để trống.',
            'name.max' => 'Tên tag không được vượt quá :max ký tự.',
            'name.unique' => 'Tag đã tồn tại.',
        ]);

        $tag->update($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được cập nhật.');
    }

    public function destroy(Tag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được xóa.');
    }
}
