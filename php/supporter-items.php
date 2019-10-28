<?php
/*
php/supporter-items.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the result items in listview format for supporters
The variable $array must be specified before including this file to refer to the appropriate array of records (containing either expert or student reviewers)

This file is included in the file 'php/content/content-experts.php'
*/

foreach($array as $expert)
{
    require 'php/expert-format.php'; // get dynamic variables created by 'php/get-field.php' and format data

    // output data for expert
    echo '<div class = "top-10 bottom-20">';
        echo '<div class = "expert-photo">';
            if($expertPhoto != NULL) { echo '<img src = "php/img.php?-url='.urlencode($expertPhoto).'">'; }
            else { echo '<div class = "no-photo-container"><div class = "no-photo">No photo available</div></div>'; }
        echo '</div>';
        echo '<div class = "expert-text">';
            echo '<div class = "expert-name">'.$expertFullName.'</div>'; // /.expert-name
            echo '<div class = "expert-title">'.$expertTitleLine.'</div>'; // .expert-title
            echo '<div class = "top-10 expert-bio">'.$bioPreview.'</div>'; // .expert-bio-preview
            echo '<div class = "top-10 no-print"><a href = "'.$expertProfileURL.'">Read more</a></div>'; // read more
        echo '</div>'; // /.expert-text
    echo '</div>'; // /.expert-item
} // end foreach $expert
?>