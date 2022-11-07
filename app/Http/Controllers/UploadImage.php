<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class UploadImage extends Controller
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
            'image' => ['required', File::image()->max(1024 * 5)],
        ]);

        /** @var UploadedFile $image */
        $image = $validated['image'];

        $path = $image->store('images', 'public');

        $is_optimize = false;
        $optimize_cost = null;
        if ($image->getSize() > 256 * 1024) {
            $is_optimize = true;
            $optimize_cost = Benchmark::measure(
                fn() => Image::load(Storage::disk('public')->path($path))
                    ->fit(Manipulations::FIT_MAX, 1600, 99999)
                    ->optimize()
                    ->save(),
                1);
        }

        return [
            'is_optimize' => $is_optimize,
            'optimize_cost' => $optimize_cost,
            'location' => Storage::disk('public')->url($path),
        ];
    }
}
