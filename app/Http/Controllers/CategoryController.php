<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index', [
            'categories' => Category::all(),
        ]);
    }

    public function show(Category $category)
    {
        return view('category.show', [
            'category' => $category,
        ]);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'max:255', 'unique:categories'],
            'title' => ['required', 'max:255'],
            'color' => ['required', 'regex:/#[0-9A-F]{6}/i'],
            'description' => ['required'],
            'logo' => ['required', 'image', 'max:200'],
        ]);

        $logo = $validated['logo'];
        unset($validated['logo']);

        $category = Category::create($validated);

        if ($logo) {
            $category
                ->addMedia($logo)
                ->toMediaCollection();
        }

        return redirect(route('categories.show', $category))
            ->with('success', '成功创建分类!');
    }

    public function edit(Category $category)
    {
        return view('category.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'title' => ['required', 'max:255'],
            'color' => ['required', 'regex:/#[0-9A-F]{6}/i'],
            'description' => ['required'],
            'logo' => ['image', 'max:200'],
        ]);

        $logo = null;
        if ($validated['logo'] ?? false) {
            $logo = $validated['logo'];
            unset($validated['logo']);
        }

        $category->update($validated);

        if ($logo) {
            $category->clearMediaCollection();
            $category
                ->addMedia($logo)
                ->toMediaCollection();
        }

        return redirect(route('categories.show', $category))
            ->with('success', '成功保存分类!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', '成功删除分类!');
    }
}
