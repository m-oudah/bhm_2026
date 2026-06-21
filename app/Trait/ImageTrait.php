<?php
namespace App\Trait;

trait ImageTrait
{
    protected function SaveImage($photo, $folder)
    {
        $file = $photo;
        $fileName = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $fileName);
    
        return $fileName;
    }
    
}