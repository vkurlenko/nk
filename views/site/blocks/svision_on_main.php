<section id="supervision" class="section-center alignment-block">
    <h2>Авторский надзор</h2>

    <p>Авторы тортов постоянно контролируют качество на местах</p>

    <a href="supervision">Все видео &gt;</a>

    <div class="container-fluid">

        <div class="row">

            <?php
            $i = 0;
            //debug($s_vision);
            foreach($s_vision as $video):
                if(!$video['size'])
                    $i % 2 ? $align = 'align-right' : $align = 'align-left';
                else{
                    $align = '';
                    $i = 1;
                }

                ?>

                <div class="<?= $video['size'] ? 'col-sm-12' : 'col-sm-6'?> video <?= $align;?>">
                    <div class="yt-cover yt-start" data-src="<?=$video['video']?>" data-source="<?=$video['source']?>">
                        <img src="<?=$video['cover']?>">
                        <div class="yt-container">
                            <i class="far fa-play-circle"></i>
                        </div>
                    </div>

                    <span class="video-title"><?=$video['title']?></span>
                    <span class="video-date"><?=$video['date']?><!--10 сентября, 2018--></span>
                    <p><?=$video['descr']?></p>
                    <a href="/" class="yt-start">Смотрите видео репортаж <i class="far fa-play-circle"></i></a>
                </div>

                <?php
                $i++;
            endforeach;
            ?>
        </div>
    </div>

    <!--<div class="container-fluid">

        <div class="row">

            <div class="col-sm-6 video align-left">

                <div class="yt-cover yt-start" data-src="BrQ17Yqbe70" id="BrQ17Yqbe70">
                    <img src="/images/6456.jpg">
                    <div class="yt-container">
                        <i class="far fa-play-circle"></i>
                    </div>
                </div>
                <span class="video-title">Маша Иванова в Самаре</span>
                <span class="video-date">10 сентября, 2018</span>
                <p>Маша посетила производство тортов на фабрике "Конфети", качество на высоте!</p>
                <a href="/" class="yt-start">Смотрите видео репортаж <i class="far fa-play-circle"></i></a>
            </div>

            <div class="col-sm-6 video align-right">
                <div class="yt-cover yt-start" data-src="BrQ17Yqbe70">
                    <img src="/images/6456.jpg">
                    <div class="yt-container">
                        <i class="far fa-play-circle"></i>
                    </div>
                </div>
                <span class="video-title">Маша Иванова в Самаре</span>
                <span class="video-date">10 сентября, 2018</span>
                <p>Маша посетила производство тортов на фабрике "Конфети", качество на высоте!</p>
                <a href="/" class="yt-start">Смотрите видео репортаж <i class="far fa-play-circle"></i></a>
            </div>

        </div>
    </div>-->
    <hr>
</section>