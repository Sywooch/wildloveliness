<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\FrontendAsset;

FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- Preloader -->
    <div class="preloader">
        <svg viewBox="-4000 -2000 8000 4000">
            <style>
                svg { background: #000 }rect, [r], #m { fill: #fff }
            </style>
            <radialGradient id="r">
                <stop stop-color="#5ad297" offset=".72"></stop>
                <stop stop-color="#8bc296" offset=".73"></stop>
                <stop stop-color="#90ba87" offset=".91"></stop>
                <stop stop-color="#ccd5a6" offset=".15"></stop>
            </radialGradient>
            <filter id="f">
                <feGaussianBlur in="SourceGraphic" stdDeviation="8"></feGaussianBlur>
            </filter>
            <mask id="m">
                <path d="M500 170c200 340 820 340 780 -290c-200 0 -600 -60 -780 290" filter="url(#f)"></path>
            </mask>
            <g id="g" mask="url(#m)" filter="url(#f)">
                <rect width="2000" height="2000"></rect>
                <ellipse cx="930" cy="-70" rx="420" ry="500" fill="url(#r)"></ellipse>
                <ellipse cx="950" cy="-20" rx="200" ry="260" transform="rotate(-9 950 -20)"></ellipse>
                <circle cx="860" cy="-20" r="14"></circle>
            </g>
            <use xlink:href="#g" transform="scale(-1 1)"></use>
        </svg>
    </div>
    <?php $this->registerJsFile("@web/js/cat.eyes.preloader.js"); ?>

    <!-- Header -->
    <section class="main-header">

        <?php NavBar::begin([
            'brandLabel' => Html::img('@web/imgs/logo/logo.png', ['alt'=>Yii::$app->name]) .
                            Html::tag('span', Html::encode(Yii::$app->name)) ,
            'brandUrl' => Yii::$app->homeUrl,
            'containerOptions' => ['class' => 'collapse navbar-collapse text-center'],
            'options' => ['class' => 'navbar navbar-default navbar-fixed-top'],
        ]);

        $menuItems = [
            ['label' => Yii::t('front','Kittens'), 'url' => ['/site/kittens-for-sale']],
            ['label' => 'Производители', 'url' => ['/site/cats']],
            ['label' => 'Выпускники', 'url' => ['/site/alumnuses']],
            ['label' => 'Контакты', 'url' => ['/site/contact']],
        ];

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $menuItems,
        ]); ?>
        <div class="social-media hidden-xs hidden-sm">
            <ul class="nav navbar-nav">
                <li><a href="#"><i class="fa fa-facebook fa-2x"></i></a></li>
                <li><a href="#"><i class="fa fa-vk fa-2x"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram fa-2x"></i></a></li>
                <li><a href="#"><i class="fa fa-odnoklassniki fa-2x"></i></a></li>
            </ul>
        </div>
        <?php NavBar::end(); ?>

        <div id="owl-hero" class="owl-carousel owl-theme">
            <div class="item" style="background-image: url('/web/uploads/_slider/mary02.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/aine04.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/ayslinn02.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/oin01.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/aine01.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/ayslinn04.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/valkyrie.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/ayslinn08.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/aine03.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/mary01.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/oin02.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/ayslinn07.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/aine02.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/ayslinn06.jpg')"></div>
            <div class="item" style="background-image: url('/web/uploads/_slider/ayslinn09.jpg')"></div>
        </div>
        
    </section>


    <!-- Breadcrumbs and content
    ============================================= -->
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>


    <!-- Welcome
    ============================================= -->
    <section id="welcome">
        <div class="container">
            <h2>Welcome To <span>Rise</span></h2>
            <hr class="sep">
            <p>Make Yourself At Home Don't Be Shy</p>
        </div>
    </section>

    <!-- Services
    ============================================= -->
    <section id="services">
        <div class="container">
            <h2>What We Do</h2>
            <img src="/imgs/logo/logo_big.png" alt="Wild loveliness">
            <hr class="light-sep">
            <p>We Can Do Crazy Things</p>
            <div class="services-box">
                <div class="row wow fadeInUp" data-wow-delay=".3s">
                    <div class="col-md-4">
                        <div class="media-left"><span class="icon-lightbulb"></span></div>
                        <div class="media-body">
                            <h3>Creative Design</h3>
                            <p>Fringilla augue at maximus vestibulum. Nam pulvinar vitae neque et porttitor. Praesent sed nisi eleifend.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="media-left"><span class="icon-mobile"></span></div>
                        <div class="media-body">
                            <h3>Bootstrap</h3>
                            <p>Fringilla augue at maximus vestibulum. Nam pulvinar vitae neque et porttitor. Praesent sed nisi eleifend.</p>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="media-left"><span class="icon-compass"></span></div>
                        <div class="media-body">
                            <h3>Sass &amp; Compass</h3>
                            <p>Fringilla augue at maximus vestibulum. Nam pulvinar vitae neque et porttitor. Praesent sed nisi eleifend.</p>
                        </div>

                    </div>

                    <div class="row wow fadeInUp" data-wow-delay=".6s">
                        <div class="col-md-4">
                            <div class="media-left"><span class="icon-adjustments"></span></div>
                            <div class="media-body">
                                <h3>Easy To Customize</h3>
                                <p>Fringilla augue at maximus vestibulum. Nam pulvinar vitae neque et porttitor. Praesent sed nisi eleifend.</p>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="media-left"><span class="icon-tools"></span></div>
                            <div class="media-body">
                                <h3>Photoshop</h3>
                                <p>Fringilla augue at maximus vestibulum. Nam pulvinar vitae neque et porttitor. Praesent sed nisi eleifend.</p>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="media-left"><span class="icon-wallet"></span></div>
                            <div class="media-body">
                                <h3>Money Saver</h3>
                                <p>Fringilla augue at maximus vestibulum. Nam pulvinar vitae neque et porttitor. Praesent sed nisi eleifend.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio
    ============================================= -->
    <section id="portfolio">
        <div class="container-fluid">
            <h2>Our Work</h2>
            <hr class="sep">
            <p>Showcase Your Amazing Work With Us</p>
            <div class="row">
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
                    <a class="portfolio-box" href="/web/imgs/portfolio/1.jpg" data-lightbox="image-1" data-title="Your caption">
                        <img src="/web/imgs/portfolio/1.jpg" class="img-responsive" alt="1">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
                    <a href="/web/imgs/portfolio/2.jpg" class="portfolio-box" data-lightbox="image-2" data-title="Your caption">
                        <img src="/web/imgs/portfolio/2.jpg" class="img-responsive" alt="2">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
                    <a href="/web/imgs/portfolio/3.jpg" class="portfolio-box" data-lightbox="image-3" data-title="Your caption">
                        <img src="/web/imgs/portfolio/3.jpg" class="img-responsive" alt="3">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
                    <a href="/web/imgs/portfolio/4.jpg" class="portfolio-box" data-lightbox="image-4" data-title="Your caption">
                        <img src="/web/imgs/portfolio/4.jpg" class="img-responsive" alt="4">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
                    <a href="/web/imgs/portfolio/5.jpg" class="portfolio-box" data-lightbox="image-5" data-title="Your caption">
                        <img src="/web/imgs/portfolio/5.jpg" class="img-responsive" alt="5">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
                    <a href="/web/imgs/portfolio/6.jpg" class="portfolio-box" data-lightbox="image-6" data-title="Your caption">
                        <img src="/web/imgs/portfolio/6.jpg" class="img-responsive" alt="6">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Work Process
    ============================================= -->
    <section id="breed-characteristics">
        <div class="container">
            <h2>Характерные черты породы</h2>
            <p>Что можно сказать о бенгальских кошках коротко</p>
            <hr class="sep">

        <div class="dots-wrap">
            <ul id='characteristics-carousel-custom-dots' class='owl-dots'> 
              <li class='owl-dot img-responsive active' data-count="1"><img class="character-icon" src="/imgs/icons/tender.svg"></li>
              <li class='owl-dot img-responsive' data-count="2"><img class="character-icon" src="/imgs/icons/moult.svg"></li>
              <li class='owl-dot img-responsive' data-count="3"><img class="character-icon" src="/imgs/icons/health.svg"></li>
              <li class='owl-dot img-responsive' data-count="4"><img class="character-icon" src="/imgs/icons/playfulness.svg"></li>
              <li class='owl-dot img-responsive' data-count="5"><img class="character-icon" src="/imgs/icons/volubility.svg"></li>
              <li class='owl-dot img-responsive' data-count="6"><img class="character-icon" src="/imgs/icons/friendliness_to_children.svg"></li>
              <li class='owl-dot img-responsive' data-count="7"><img class="character-icon" src="/imgs/icons/easy_care.svg"></li>
              <li class='owl-dot img-responsive' data-count="8"><img class="character-icon" src="/imgs/icons/intelligence.svg"></li>
              <li class='owl-dot img-responsive' data-count="9"><img class="character-icon" src="/imgs/icons/friendliness_to_pets.svg"></li>
            </ul>
        </div>

        <div id="owl-characteristics" class="owl-carousel owl-theme">
            <div class="item">
                <h4>Ласковая в семье</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                </div>
                <p>В большинстве своем породы кошек, как правило, характеризуются независимостью и отчужденностью, даже если кошка выросла рядом с человеком с возраста котенка. Некоторые привязывается к одному человеку и равнодушны ко всем остальным, другие же одаряют своей лаской всю семью. Порода не единственный фактор, который влияет на уровень привязанности. Кошки, которые выросли в доме, где всегда есть люди чувствуют себя более комфортно с людьми и легче привязываются.</p>
            </div>
            <div class="item">
                <h4>Линька</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_disabled.svg">
                    <img src="/imgs/star_disabled.svg">
                    <img src="/imgs/star_disabled.svg">
                </div>
                <p>Если вы собираетесь разделить свой дом с кошкой, то вам придется иметь дело с кошачьей шерстью на вашей одежде и в доме. Однако, линька для разных пород проявляется в разной степени.</p>
            </div>
            <div class="item">
                <h4>Здоровье</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_disabled.svg">
                    <img src="/imgs/star_disabled.svg">
                </div>
                <p>Из-за плохой селекционной практики, некоторые породы склонны к определенным генетическим проблемам со здоровьем. Это не означает, что у каждой кошки этой породы будут развиваться эти заболевания; это просто означает, что они в зоне повышенного риска. Если вы ищете только породистых кошек или котят, Вам следует заранее выяснить, какие генетические недуги характерны для той породы, которая Вас интересует.</p>
            </div>
            <div class="item">
                <h4>Игривость</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                </div>
                <p>Некоторые кошки вечные котята — полны энергии и озорства — в то время как другие наоборот серьезные и спокойные. Хотя "игривый котенок" звучит ласково, подумайте, насколько много вы готовы участвовать в играх-гонках за мышкой-игрушкой каждый день, и есть ли у вас дети или другие животные, которые могут составить компанию в качестве товарищей по играм.</p>
            </div>
            <div class="item">
                <h4>Говорливость</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_disabled.svg">
                </div>
                <p>Некоторые породы проявляют свои вокальные качества чаще, чем другие. При выборе породы, подумайте о том, как кошки издают звуки и как часто. Если постоянный "разговор" сводит вас с ума, рассмотрите вариант с кошкой, менее требовательной к общению.</p>
            </div>
            <div class="item">
                <h4>Дружелюбие к детям</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                </div>
                <p>Терпимость к детям, достаточная, чтобы справиться с тяжелой рукой и крепкими объятиям, безразличное отношение к бегу малышей - те черты характера, которые определяют кошку как дружелюбную по отношению к детям. Такие рейтинги являются обобщением, и они не являются гарантией соответствующего поведения у любой породы или отдельно взятой кошки. Кошки любой породы могут быть хорошими с детьми основываясь на своем прошлом опыте и личности.</p>
            </div>
            <div class="item">
                <h4>Простота в уходе</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_disabled.svg">
                </div>
                <p>Некоторые породы требуют очень мало ухода, другие необходимо регулярно расчесывать, чтобы они оставались чистыми и здоровыми. Подумайте, есть ли у Вас время и терпение для кошки, которой необходимо ежедневное расчесывание.</p>
            </div>
            <div class="item">
                <h4>Интеллект</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                </div>
                <p>Некоторые породы кошек имеют репутацию, как о более умных, чем другие. Но все кошки, если их лишают умственной стимуляции будут заниматься своими собственными делами. Интерактивные игрушки - хороший способ тренировки мозга кошки и удержания ее от шалостей.</p>
            </div>
            <div class="item">
                <h4>Дружелюбие к питомцам</h4>
                <div class="star-rating">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                    <img src="/imgs/star_enabled.svg">
                </div>
                <p>Дружественность по отношению к другим домашним животным и дружелюбие по отношению к людям - это две абсолютно разные вещи. Некоторые кошки ладят с другими домашними животными в доме лучше чем другие.</p>
            </div>
        </div>

        





            
        </div>
    </section>

    <!-- Some Fune Facts
    ============================================= -->
    <section id="fun-facts">
        <div class="container">
            <h2>Наши маленькие рекорды</h2>
            <hr class="light-sep">
            <div class="row wow fadeInUp" data-wow-delay=".3s">
                <div class="col-lg-3">
                    <img src="/imgs/icons/chickens.svg">

                    <h2 class="number timer">1637</h2>
                    <h4>Цыплят<br>съедено</h4>
                </div>
                <div class="col-lg-3">
                    <img src="/imgs/icons/awards.svg">
                    <h2 class="number timer">13</h2>
                    <h4>Оценок<br>получено</h4>
                </div>
                <div class="col-lg-3">
                    <img src="/imgs/icons/toys.svg">
                    <h2 class="number timer">27</h2>
                    <h4>Игрушек<br>уничтожено</h4>
                </div>
                <div class="col-lg-3">
                    <img src="/imgs/icons/sleep.svg">
                    <h2 class="number timer">145</h2>
                    <h4>Часов сна<br>потеряно</h4>
                </div>
            </div>
        </div>
    </section>
    <!-- Some Fune Facts
    ============================================= -->
    <section id="team">
        <div class="container">
            <h2>Our Team</h2>
            <hr class="sep">
            <p>Designers Behind This Work</p>
            <div class="row wow fadeInUp" data-wow-delay=".3s">
                <div class="col-md-4">
                    <div class="team">
                        <img class="img-responsive center-block" src="/web/imgs/team/MariaDoe.jpg" alt="1">
                        <h4>Maria Doe</h4>
                        <p>Designer</p>
                        <div class="team-social-icons">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team">
                        <img class="img-responsive center-block" src="/web/imgs/team/JasonDoe.jpg" alt="2">
                        <h4>Jason Doe</h4>
                        <p>Developer</p>
                        <div class="team-social-icons">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team">
                        <img class="img-responsive center-block" src="/web/imgs/team/MikeDoe.jpg" alt="3">
                        <h4>Mike Doe</h4>
                        <p>Photographer</p>
                        <div class="team-social-icons">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials
    ============================================= -->
    <section id="testimonials">
        <div class="container">
            <h2>Testimonials</h2>
            <hr class="light-sep">
            <p>What Clients Say About Us</p>
            <div id="owl-testi" class="owl-carousel owl-theme">
                <div class="item">
                    <div class="quote">
                        <i class="fa fa-quote-left left fa-2x"></i>
                        <h5>I’am amazed, I should say thank you so much for your awesome template. Design is so 
good and neat, every detail has been taken care these team are realy amazing and talented! I will 
work only with <span>Rise</span>.<i class="fa fa-quote-right right fa-2x"></i></h5>

                    </div>
                </div>
                <div class="item">
                    <div class="quote">
                        <i class="fa fa-quote-left left fa-2x"></i>
                        <h5>I’am amazed, I should say thank you so much for your awesome template. Design is so 
good and neat, every detail has been taken care these team are realy amazing and talented! I will 
work only with <span>Rise</span>.<i class="fa fa-quote-right right fa-2x"></i></h5>

                    </div>
                </div>
                <div class="item">
                    <div class="quote">
                        <i class="fa fa-quote-left left fa-2x"></i>
                        <h5>I’am amazed, I should say thank you so much for your awesome template. Design is so 
good and neat, every detail has been taken care these team are realy amazing and talented! I will 
work only with <span>Rise</span>.<i class="fa fa-quote-right right fa-2x"></i></h5>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Us
    ============================================= -->
    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <hr class="sep">
            <p>Get In Touch</p>
            <div class="col-md-6 col-md-offset-3 wow fadeInUp" data-wow-delay=".3s">
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" id="Name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="Email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="Message"></textarea>
                    </div>
                    <a href="#" class="btn-block">Send</a>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer
    ============================================= -->
    <footer>
        <div class="container">
            <div class="social">
                <a href="#"><i class="fa fa-facebook fa-2x"></i></a>
                <a href="#"><i class="fa fa-vk fa-2x"></i></a>
                <a href="#"><i class="fa fa-instagram fa-2x"></i></a>
                <a href="#"><i class="fa fa-odnoklassniki fa-2x"></i></a>
            </div>
            <span class="copyright">&copy; Wild loveliness, <span class="established-date">2016 - <?= date('Y') ?></span></span>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>