<?php 

function quick_info($args){
    
    $values = array();
    $return = "";
    $rows = get_field('info',2);
    
    if($rows):
         foreach($rows as $row):
         if($row['label']=="Age"){
            array_push($values, do_shortcode('[my_age]'));
            continue;
         }
         $values[] = $row['answer'];
         endforeach;
    endif;
    
    shuffle($values);
    
    if ($values) {
        foreach($values as $value){
            $return .="<li>{$value}</li>";
        }
    } else{
        $return .= "Jess or Koko";
    }
    
    return $return;
}

add_shortcode('quick_info','quick_info');

function my_age($args){
    
    $rows = get_field('info',2);
    
    if($rows):
        foreach($rows as $row):
            if($row['label']=="Age"):
                $birthday = $row['answer'];
            endif;
        endforeach;
    endif;
    
    $return = "";
    
    if ($birthday) {
        
        $birthdate = new DateTime($birthday);
        $now       = new DateTime();
        $interval  = $now->diff($birthdate);
        $return    =  $interval->y;
        
    }
    

    return $return;
}

add_shortcode('my_age','my_age');

function birthday($args){
    
    $rows = get_field('info',2);
    
    if($rows):
        foreach($rows as $row):
            if($row['label']=="Age"):
                $birthday = $row['answer'];
            endif;
        endforeach;
    endif;
    $return = "";
    
    if ($birthday) {
        
        $birthdate = strtotime($birthday);
        $return    = date('F jS',$birthdate);
        
    }
    

    return $return;
}

add_shortcode('birthday','birthday');

function art_samples($args){
    
    $art_samples = get_field("art_samples",15);
    $return = "";
    
    shuffle($art_samples);
    
    if ($art_samples) {
        
        foreach($art_samples as $id){
            $src = wp_get_attachment_image_url($id, 'full');
            $caption = wp_get_attachment_caption($id);
            $return .="<div class='img-group'>
                <img class='art-img' src='{$src}' alt='{$caption} art example' />
                <span class='img-caption'>{$caption}</span>
            </div>";
        }
        
    }
    

    return $return;
}

add_shortcode('art_samples','art_samples');

function commission_goal() {
    $desc = get_field('commission_desc','option');
    $range = get_field('commission_goal','option');
    $return = "
    <div class='wrapper'>
        <div class='small'>{$desc}</div>
        <div class='bar-wrapper'>
            <div class='bar' style='width:{$range}%'></div>
            <span class='goal-label'>{$range}% to Goal</span>
        </div>
    </div>
    ";
    return $return;
}
add_shortcode('commission_goal','commission_goal');