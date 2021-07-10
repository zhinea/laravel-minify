<?php

namespace Dyumna\Minify\Support;

class Finder
{


    /**
     * Search file
     */
    public function search($ext, $ext2 = false)
    {
        $rii = $this->dir(config('minify.base_path'));

        $files = [];

        foreach ($rii as $file) {
            if ($file->isDir() || !preg_match('/\.'. $ext .'$/', $file->getPathname())) {
                if ($ext === false) {
                    continue;
                }
                if (!preg_match('/\.'. $ext2 .'$/', $file->getPathname())) {
                    continue;
                }
            }

            $files[] = $file->getPathname();
        }

        return $files;
    }


    /**
     * Get lists directory
     */
    public function dir($dir)
    {
        return (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir)));
    }
}
