<?php
/**
 * @package     BR Simple Carousel
 * @author      Janderson Moreira
 * @copyright   Copyright (C) 2026 Janderson Moreira
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

// Inclui o arquivo Helper localizado na raiz
require_once __DIR__ . '/helper.php';

// 1. Coleta os parâmetros do XML
$folderPath      = $params->get('folder_path', 'headers');
$duration        = $params->get('slide_duration', 5);
$height          = $params->get('carousel_height', '200px');
$maxWidth        = $params->get('carousel_max_width', '1200px');
$fitMode         = $params->get('fit_mode', 'cover');
$itemsDesktop    = $params->get('items_desktop', 4);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8');

// 2. Busca os dados no Helper
$result = ModBrSimpleCarouselHelper::getImages($folderPath);
$images = $result['images'];
$error  = $result['error'];

// 3. Carrega o Layout
if (!empty($images) || !empty($error)) {
    require ModuleHelper::getLayoutPath('mod_br_simple_carousel', $params->get('layout', 'default'));
}