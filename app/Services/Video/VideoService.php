<?php

namespace App\Services\Video;

use App\Models\Language;

class VideoService
{
    public function getVideoLinks(Language $language): array
    {
        $videoDirectory = storage_path('app/public/videos/' . $language->code);
    
        // Получаем список файлов в директории
        $videoFiles = scandir($videoDirectory);

        // Фильтруем только видеофайлы (можно добавить другие расширения)
        $videoFiles = array_filter($videoFiles, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'mp4';
        });

        // Создаем массив ссылок на видеофайлы
        $videoLinks = array_map(function ($videoFile) use ($language) {
            return asset('storage/videos/' . $language->code . '/' . $videoFile);
        }, $videoFiles);

        return $videoLinks;
    }
}