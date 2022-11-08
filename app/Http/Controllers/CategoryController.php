<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index()
    {
        return view('category.index', [
            'categories' => Category::query()->with('author')->get(),
        ]);
    }

    public function show(Category $category)
    {
        return view('category.show', [
            'category' => $category,
            'topics' => $category->topics()->latest()->paginate(),
        ]);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $logo = $validated['logo'];
        unset($validated['logo']);

        $category = $request->user()->categories()->create($validated);

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

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

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
