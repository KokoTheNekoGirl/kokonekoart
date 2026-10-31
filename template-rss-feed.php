<?php
/**
 * Template Name: RSS Feed
 * Template Post Type: page
 * Description: Custom template to display RSS feeds
 */

get_header(); ?>
<div class="entry-content" itemprop="mainContentOfPage">
    <section id="boxed-content">
    <h1><?php the_title(); ?></h1>
    
    <?php
    $all_items = array();
    $feed_sources = array();
    
    if (have_rows('rss_feed','option')) :
        
        while (have_rows('rss_feed','option')) : the_row();
            
            $feed_url = get_sub_field('url');
            
            if ($feed_url) :
                $rss = fetch_feed($feed_url);
                
                if (!is_wp_error($rss)) :
                    $feed_title = $rss->get_title();
                    $rss_items = $rss->get_items();
                    
                    foreach ($rss_items as $item) {
                        $item_url = $item->get_permalink();
                        $item_title = $item->get_title();
                        
                        if (strpos($item_url, '/shorts/')) {
                            continue;
                        }
                        
                        $all_items[] = array(
                            'item' => $item,
                            'source' => $feed_title,
                            'timestamp' => $item->get_date('U')
                        );
                    }
                else :
                    $feed_sources[] = array(
                        'name' => $feed_name ?: $feed_url,
                        'error' => $rss->get_error_message()
                    );
                endif;
            endif;
            
        endwhile;
        
        usort($all_items, function($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });
        
        $items_per_page = 10;
        $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
        $total_items = count($all_items);
        $total_pages = ceil($total_items / $items_per_page);
        $offset = ($current_page - 1) * $items_per_page;
        $paginated_items = array_slice($all_items, $offset, $items_per_page);
        
        if (!empty($feed_sources)) :
            foreach ($feed_sources as $source) :
                if (isset($source['error'])) : ?>
                    <div class="feed-error" style="background:padding: 0.5em;">
                        <strong>Error loading feed:</strong> <?php echo esc_html($source['name']); ?>
                        <br>
                        <small><?php echo esc_html($source['error']); ?></small>
                    </div>
                <?php endif;
            endforeach;
        endif;
        
        if (!empty($paginated_items)) : ?>
            <div class="feed-info" style="margin-bottom: 20px; color: rgb(40,40,40); font-size: 14px;">
                Showing <?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_items); ?> of <?php echo $total_items; ?> items
            </div>
            
            <ul class="rss-items" style="list-style: none; padding: 0;">
                <?php foreach ($paginated_items as $feed_item) : 
                    $item = $feed_item['item'];
                    $source = $feed_item['source'];
                ?>
                    <li style="padding: 0.5em;display: flex; gap: 0.5em;">
                        <?php 
                        $thumbnail = null;
                        if ($enclosure = $item->get_enclosure()) {
                            $thumbnail = $enclosure->get_thumbnail();
                        }
                        
                        if ($thumbnail) : ?>
                            <div class="item-thumbnail" style="flex-shrink: 0;">
                                <a href="<?php echo esc_url($item->get_permalink()); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer">
                                    <img src="<?php echo esc_url($thumbnail); ?>" 
                                         alt="<?php echo esc_attr($item->get_title()); ?>"
                                         style="width: 200px; height: auto; border-radius: 4px; display: block;">
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="item-content" style="flex: 1; min-width: 0;">
                            <h2 style="margin: 0 0 10px 0; font-size: 20px;">
                                <a href="<?php echo esc_url($item->get_permalink()); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   style="color: rgb(var(--primary)); text-decoration: none;">
                                    <?php echo esc_html($item->get_title()); ?>
                                </a>
                            </h2>
                        
                        <div class="item-meta" style="color: rgb(40,40,40); font-size: 14px; margin-bottom: 12px;">
                            <span class="item-source" style="background: rgb(var(--primary)); color: white; padding: 2px 8px; border-radius: 3px; font-size: 12px; margin-right: 10px;">
                                <?php echo esc_html($source); ?>
                            </span>
                            
                            <?php if ($item->get_date()) : ?>
                                <span class="item-date">
                                    <?php echo esc_html($item->get_date('F j, Y - g:i a')); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($author = $item->get_author()) : ?>
                                <span class="item-author">
                                    | By <?php echo esc_html($author->get_name()); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                            
                            <div class="item-description" style="color: #444; line-height: 1.6;">
                                <?php echo wp_trim_words($item->get_description(), 50, '...'); ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <?php
            if ($total_pages > 1) : ?>
                <div class="pagination" style="margin-top: 30px; text-align: center;">
                    <?php
                    $pagination_args = array(
                        'base' => get_pagenum_link(1) . '%_%',
                        'format' => 'page/%#%/',
                        'current' => $current_page,
                        'total' => $total_pages,
                        'prev_text' => '&laquo; Previous',
                        'next_text' => 'Next &raquo;',
                        'type' => 'plain'
                    );
                    echo paginate_links($pagination_args);
                    ?>
                </div>
                
                <style>
                    .pagination a, .pagination .current {
                        padding: 8px 12px;
                        margin: 0 2px;
                        background: #f0f0f0;
                        color: rgb(var(--primary));
                        text-decoration: none;
                        border-radius: 3px;
                        display: inline-block;
                    }
                    .pagination .current {
                        background: rgb(var(--primary));
                        color: white;
                    }
                    .pagination a:hover {
                        background: rgb(var(--primary));
                        color: white;
                    }
                </style>
            <?php endif; ?>
            
        <?php else : ?>
            <p>No items found in any feeds.</p>
        <?php endif;
        
    else : ?>
        <p>No RSS feeds have been added yet.</p>
    <?php endif; ?>
    </section>
</div>

<?php get_footer(); ?>