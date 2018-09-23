<?php
$page = \app\controllers\SiteController::getPageDataByUrl('casting');
?>
<section id="takepart" class="section-center">
    <h2>Стать участником</h2>

    <!--<p>Вы можете стать участником следующего конкурса</p>-->
    <div class="content">
        <?= $page['anons']?>
    </div>

    <!--<button class="nk-button"><a href="/casting" class="btn-title" style="color:#fff">Заполните анкету для кастинга</a></button>
-->

    <a  href="/casting" class="btn-title nk-button"  style="color:#fff">Заполните анкету для кастинга</a>
    <hr>
</section>