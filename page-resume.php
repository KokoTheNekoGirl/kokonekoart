<?php

?>

<head>
    <?php wp_head(); ?>
    <meta name="robots" content="noindex, nofollow" />
</head>
<body class="resume">
    <page size="letter">
        <div class="frame">
            <img width="400" height="400" src="<?= get_template_directory_uri(); ?>/img/symbols/favicon.svg" class="resume-logo" alt="KokoNekoArt's Logo" decoding="async" loading="lazy">
        <div class="inner">
        <?php if( have_rows('about_me_header') ):?>
        <header>
            <?php while( have_rows('about_me_header') ): the_row();?>
            <h1>Jessica Humphrey</h1>
            <section class="list-container">
                <span class="list-item"><?= get_sub_field('phone');?></span>
                <span class="list-item"><?= get_sub_field('email');?></span>
                <span class="list-item"><a href="<?= esc_url( home_url( '/' ) );?>">kokoneko.art</a></span>
                <span class="list-item"><?= get_sub_field('location');?></span>
            </section>
            <p><?= get_sub_field('flavour_text');?></p>
            <?php endwhile;?>
        </header>
        <?php endif;?>
        <?php if( have_rows('education_experience') ):?>
        <h2>Education</h2>
        <?php while( have_rows('education_experience') ): the_row();?>
            <span class="experience-title">
                <h3><?= get_sub_field('institution');?></h3>
                <p><?= get_sub_field('from')  . " - "; ?><?= (get_sub_field('present')) ? "Present ": get_sub_field('to')?></p></span>
            <p class="credentials"><?= get_sub_field('credentials');?></p>
            <ul class="skills-list">
                <?php foreach(get_sub_field('skills') as $item):?>
                <li><?= $item['skill'];?></li>
                <?php endforeach;?>
            </ul>
        <?php endwhile;?>
        <?php endif;?>
        <?php if( have_rows('work_experience') ):?>
        <h2>Work Experience</h2>
        <?php while( have_rows('work_experience') ): the_row();
        $first_child = 0;?>
        <div class="experience">
            <span class="experience-title">
                <h3><?= get_sub_field('role');?></h3>
                <p>
                    <?php if(get_sub_field('present') && $first_child == 0): ?>
                    (current)
                    <?php $first_child = 1;
                    elseif(get_sub_field('present') && $first_child > 0): ?>
                    <?php else:?>
                    <?= get_sub_field('from'); ?><?= (get_sub_field('to') > get_sub_field('from')) ? " - ".get_sub_field('to') : "";?></p></span>
                    <?php endif;?>
            <section class="list-container">
                <span class="list-item"><?= get_sub_field('employer');?></span>
                <span class="list-item"><?= get_sub_field('location');?></span>
                <?php if(get_sub_field('present')):?>
                <span class="list-item"><?= get_sub_field('from')  . " - Present ";?></span>
                <?php endif;?>
            </section>
            <ul class="skills-list">
                <?php foreach(get_sub_field('skills') as $item):?>
                <li><?= $item['skill'];?></li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endwhile;?>
        <?php endif;?>
        </div>
    </page>
    <!--<page size="letter">-->
    <!--    <div class="frame">-->
            
    <!--    </div>-->
    <!--</page>-->
    <page size="letter">
        <div class="frame">
            
        </div>
    </page>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js" ></script>
    <?php //wp_footer(); ?>
</body>