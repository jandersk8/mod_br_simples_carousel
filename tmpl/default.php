<?php
/**
 * @package     BR Simple Carousel
 * @author      Janderson Moreira
 * @copyright   Copyright (C) 2026 Janderson Moreira
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!empty($error)) : ?>
    <div class="br-carousel-error" style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 4px; margin: 10px 0;">
        <strong>BR Simple Carousel:</strong> <?php echo htmlspecialchars($error); ?>
    </div>
<?php return; endif; 

$carouselId = 'br-carousel-' . $module->id;
$interval   = (int)$duration * 1000;
$gap        = 15; // Gap fixo de 15px
?>

<style>
#<?php echo $carouselId; ?>.br-carousel-viewport {
    max-width: <?php echo htmlspecialchars($maxWidth); ?>;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
}

#<?php echo $carouselId; ?> .br-carousel-track {
    display: flex;
    /* Define o espaçamento real entre os itens */
    gap: <?php echo $gap; ?>px; 
    transition: transform 0.5s ease-in-out;
}

#<?php echo $carouselId; ?> .br-carousel-item {
    /* LÓGICA: (100% da largura - soma de todos os gaps) / número de imagens */
    flex: 0 0 calc((100% - (<?php echo ($itemsDesktop - 1) * $gap; ?>px)) / <?php echo $itemsDesktop; ?>);
    height: <?php echo htmlspecialchars($height); ?>;
    box-sizing: border-box;
}

@media (max-width: 768px) {
    #<?php echo $carouselId; ?> .br-carousel-item { flex: 0 0 100%; }
    #<?php echo $carouselId; ?> .br-carousel-track { gap: 0; }
}

#<?php echo $carouselId; ?> .br-carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: <?php echo $fitMode; ?>;
    display: block;
}

#<?php echo $carouselId; ?> .br-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: #fff;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 10;
}
.br-prev { left: 0; }
.br-next { right: 0; }
</style>

<div id="<?php echo $carouselId; ?>" class="br-carousel-viewport <?php echo $moduleclass_sfx; ?>" data-interval="<?php echo $interval; ?>">
    <div class="br-carousel-track">
        <?php foreach ($images as $index => $image) : ?>
            <div class="br-carousel-item">
                <img src="<?php echo $image; ?>" alt="Image <?php echo $index + 1; ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <button class="br-nav br-prev">&lt;</button>
    <button class="br-nav br-next">&gt;</button>
</div>

<script>
(function() {
    var container = document.getElementById('<?php echo $carouselId; ?>');
    if (!container) return;

    var track = container.querySelector('.br-carousel-track');
    var items = container.querySelectorAll('.br-carousel-item');
    var index = 0;
    var autoPlay;

    function move() {
        var itemsInView = (window.innerWidth <= 768) ? 1 : <?php echo (int)$itemsDesktop; ?>;
        var maxIndex = items.length - itemsInView;
        
        if (index > maxIndex) index = 0;
        if (index < 0) index = maxIndex;

        // Pega a largura exata do item renderizado
        var itemWidth = items[0].getBoundingClientRect().width;
        // Move a largura da imagem + o gap de 15px
        var moveDistance = index * (itemWidth + (window.innerWidth <= 768 ? 0 : <?php echo $gap; ?>));
        
        track.style.transform = 'translateX(' + (-moveDistance) + 'px)';
    }

    container.querySelector('.br-next').onclick = function() { index++; move(); restart(); };
    container.querySelector('.br-prev').onclick = function() { index--; move(); restart(); };

    function start() {
        if (<?php echo $interval; ?> > 0) autoPlay = setInterval(function() { index++; move(); }, <?php echo $interval; ?>);
    }
    function restart() { clearInterval(autoPlay); start(); }

    window.addEventListener('resize', move);
    start();
})();
</script>