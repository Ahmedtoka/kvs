<?php

/*
|--------------------------------------------------------------------------
| KVS image helpers
|--------------------------------------------------------------------------
| The site auto-detects photos placed in public/images/<folder name>/.
| Each section scans its own folder; if the folder is empty or missing,
| the elegant placeholder is shown instead — nothing ever breaks.
*/

if (!function_exists('kvs_public_path')) {
    function kvs_public_path(string $rel): string
    {
        if (function_exists('public_path')) {
            return public_path($rel);
        }
        // Static-preview fallback (no Laravel runtime)
        foreach ([getcwd() . '/public/' . $rel, getcwd() . '/kvs/public/' . $rel] as $p) {
            if (file_exists($p) || is_dir($p)) {
                return $p;
            }
        }

        return getcwd() . '/public/' . $rel;
    }
}

if (!function_exists('kvs_images')) {
    /**
     * Web paths of all images inside public/images/<folder>, naturally sorted.
     * Folder names may contain spaces or apostrophes — they are URL-encoded safely.
     */
    function kvs_images(string $folder): array
    {
        $dir = kvs_public_path('images/' . $folder);
        if (!is_dir($dir)) {
            return [];
        }

        $files = [];
        foreach (scandir($dir) as $f) {
            if (preg_match('/\.(png|jpe?g|webp|svg|avif|gif)$/i', $f)) {
                $files[] = $f;
            }
        }
        natcasesort($files);

        return array_values(array_map(
            fn ($f) => '/images/' . str_replace('%2F', '/', rawurlencode($folder)) . '/' . rawurlencode($f),
            $files
        ));
    }
}

if (!function_exists('kvs_image')) {
    /** Single image (by index) from a folder, or the given fallback. */
    function kvs_image(string $folder, int $index = 0, ?string $fallback = null): ?string
    {
        $imgs = kvs_images($folder);

        return $imgs[$index] ?? $fallback;
    }
}

if (!function_exists('kvs_file')) {
    /** Web path for a single file under public/images/, or null if it does not exist. */
    function kvs_file(string $rel): ?string
    {
        return file_exists(kvs_public_path('images/' . $rel))
            ? '/images/' . implode('/', array_map('rawurlencode', explode('/', $rel)))
            : null;
    }
}
