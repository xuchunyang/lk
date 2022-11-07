<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class RenderMarkdown extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'markdown' => ['required'],
        ]);

        $html = app(MarkdownRenderer::class)->toHtml($validated['markdown']);

        return [
            'html' => $html,
        ];
    }
}
