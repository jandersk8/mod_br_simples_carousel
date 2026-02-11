<?php
/**
 * @package     BR Simple Carousel
 * @author      Janderson Moreira
 * @copyright   Copyright (C) 2026 Janderson Moreira
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

class ModBrSimpleCarouselHelper
{
    /**
     * Retrieves the list of image URLs from the specified folder.
     *
     * @param   string  $folderPath  The folder path
     * @return  array   List of images and error status
     */
    public static function getImages($folderPath)
    {
        // Limpa barras extras
        $folderPath = trim($folderPath, '/');
        
        // Se o caminho não começar com 'images', nós adicionamos (para manter compatibilidade)
        $internalPath = (strpos($folderPath, 'images') === 0) ? $folderPath : 'images/' . $folderPath;
        
        $path = JPATH_SITE . '/' . $internalPath;
        
        $images = [];
        $error = null;

        if (is_dir($path)) {
            $files = scandir($path);

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                // Filtra imagens (JPG, PNG, WEBP, GIF)
                if (preg_match('/(?i)\.(jpg|jpeg|png|webp|gif)$/', $file)) {
                    $images[] = Uri::root(true) . '/' . $internalPath . '/' . $file;
                }
            }
            
            if (empty($images)) {
                 $error = 'BR Simple Carousel: No images detected in /' . $internalPath;
            }

        } else {
            $error = 'BR Simple Carousel: Folder "/' . htmlspecialchars($internalPath) . '" not found.';
        }

        return [
            'images' => $images,
            'error'  => $error
        ];
    }
}