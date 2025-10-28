<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageHandler
{
    /**
     * Upload an image to the specified directory
     *
     * @param UploadedFile $image
     * @param string $directory
     * @param string|null $oldImagePath
     * @return string
     */
    public static function uploadImage(UploadedFile $image, string $directory, ?string $oldImagePath = null): string
    {
        // Delete old image if exists
        if ($oldImagePath) {
            self::deleteImage($oldImagePath);
        }

        // Generate unique filename
        $imageName = time() . '_' . $image->getClientOriginalName();
        
        // Create directory if it doesn't exist
        $uploadPath = public_path($directory);
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Move the image
        $image->move($uploadPath, $imageName);
        
        return $directory . '/' . $imageName;
    }

    /**
     * Delete an image file
     *
     * @param string $imagePath
     * @return bool
     */
    public static function deleteImage(string $imagePath): bool
    {
        $fullPath = public_path($imagePath);
        
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        
        return false;
    }

    /**
     * Delete multiple images
     *
     * @param array $imagePaths
     * @return array
     */
    public static function deleteMultipleImages(array $imagePaths): array
    {
        $results = [];
        
        foreach ($imagePaths as $path) {
            $results[$path] = self::deleteImage($path);
        }
        
        return $results;
    }

    /**
     * Get valid image extensions
     *
     * @return array
     */
    public static function getValidExtensions(): array
    {
        return ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'];
    }

    /**
     * Get validation rules for image upload
     *
     * @param int $maxSize Maximum size in KB (default 2MB)
     * @return string
     */
    public static function getValidationRules(int $maxSize = 2048): string
    {
        $extensions = implode(',', self::getValidExtensions());
        return "image|mimes:{$extensions}|max:{$maxSize}";
    }
}