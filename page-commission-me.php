<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="header entry-title">
    <h1 class="animate__animated animate__fadeInUp" itemprop="name"><?php the_title(); ?></h1>
</header>
<div class="entry-content" itemprop="mainContentOfPage">
    <span class="center"><?php the_content();?></span>
    <section class="comms-section">
        <div class="art-sample-cont">
            <div data-char-shot="hs" data-art-style='sketch' id="art-sample"></div>
            <div class='art-bg' data-bg='trans'></div>
        </div>
        <div class="comms-btn">
            <h3>Character Shot</h3>
            <div class="btn-group" id="char-shot-group">
                <div class="button">
                    <input type="radio" id="hs" name="char-shots" data-locked="false" value="<?php the_field('headshot'); ?>" checked/>
                    <label role="button" class="btn btn-comms" for="hs">Headshot</label>
                </div>
                <div class="button">
                    <input type="radio" id="hb" name="char-shots" data-locked="false" value="<?php the_field('halfbody'); ?>"/>
                    <label role="button" class="btn btn-comms" for="hb">Halfbody</label>
                </div>
                <div class="button">
                    <input type="radio" id="fb" name="char-shots" data-locked="false" value="<?php the_field('fullbody'); ?>"/>
                    <label role="button" class="btn btn-comms" for="fb">Fullbody</label>
                </div>
                <div class="button">
                    <input type="radio" id="chibi" name="char-shots" data-locked="false" value="<?php the_field('chibi'); ?>"/>
                    <label role="button" class="btn btn-comms" for="chibi">Chibi</label>
                </div>
            </div>
            <h3>Art Finish</h3>
            <div class="btn-group" id="art-style-group">
                <div class="button">
                    <input type="radio" id="sketch" name="art-style" data-locked="false" value="<?php the_field('sketch'); ?>" checked/>
                    <label role="button" class="btn btn-comms" for="sketch">Sketch</label>
                </div>
                <div class="button">
                    <input type="radio" id="line" name="art-style" data-locked="false" value="<?php the_field('lineart'); ?>"/>
                    <label role="button" class="btn btn-comms" for="line">Lineart</label>
                </div>
                <div class="button">
                    <input type="radio" id="flat" name="art-style" data-locked="false" value="<?php the_field('flatcolor'); ?>"/>
                    <label role="button" class="btn btn-comms" for="flat">Flatcolor</label>
                </div>
                <div class="button">
                    <input type="radio" id="shaded" name="art-style" data-locked="false" value="<?php the_field('shaded'); ?>"/>
                    <label role="button" class="btn btn-comms" for="shaded">Shaded</label>
                </div>
            </div>
            <h3>Background</h3>
            <div class="btn-group" id="bg-group">
                <div class="button">
                    <input type="radio" id="trans" name="bg" data-locked="false" value="<?php the_field('transparent'); ?>" checked/>
                    <label role="button" class="btn btn-comms" for="trans">Transparent</label>
                </div>
                <div class="button">
                    <input type="radio" id="color" name="bg" data-locked="false" value="<?php the_field('color'); ?>"/>
                    <label role="button" class="btn btn-comms" for="color">Color</label>
                </div>
                <div class="button">
                    <input type="radio" id="pattern" name="bg" data-locked="true" value="<?php the_field('pattern'); ?>"/>
                    <label role="button" class="btn btn-comms locked" for="pattern">Pattern</label>
                </div>
                <div class="button">
                    <input type="radio" id="scene" name="bg" data-locked="true" value="<?php the_field('scene'); ?>"/>
                    <label role="button" class="btn btn-comms locked" for="scene">Scene</label>
                </div>
            </div>
            <h4>Add-ons</h4>
            <div class="checkboxes">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="complex" value="<?php the_field('complex'); ?>"/>
                    <label for="complex" class="check-box"></label>
                    <p class="large-p text-label" data-for="complex">Complex Design</p>
                </div>
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="add_char" value="<?php the_field('add_char'); ?>"/>
                    <label for="add_char" class="check-box"></label>
                    <p class="large-p text-label" data-for="add_char">Extra Character/Shot</p>
                </div>
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="ref" value="<?php the_field('ref_sheet'); ?>"/>
                    <label for="ref" class="check-box"></label>
                    <p class="large-p text-label" data-for="ref">Ref Sheet/Custom 
                        <i class="fa-solid fa-circle-info"></i>
                        <span class="includes"><?php the_field('refsheet_includes'); ?></span>
                    </p>
                </div>
            </div>
        </div>
        <div></div>
        <div class="mini-box">
            <h3 class="total"><span style="margin-right:0.5em;">Total:</span>$<span class="price">12</span>.00</h3>
            <div class="cta-buttons">
                <a class="btn btn-primary paypal-link" target="_blank" rel="external" href="https://paypal.me/kokonekoart/4" role="button"><span class="whiskers-left"></span><span class="btn-text">Pay directly</span><span class="whiskers-right"></span></a>
                <a class="btn btn-comms form-link" href="/commission-me/request?char-shots=hs&art-style=sketch&bg=trans" role="button">Request form</a>
                <a class="btn btn-comms kofi-link" rel="external" href="https://ko-fi.com/kokonekogirl" target="_blank" role="button"><span class="btn-text"><i class="fa-brands fa-ko-fi"></i> Kofi</span></a>
            </div>
        </div>
    </section>
</div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>