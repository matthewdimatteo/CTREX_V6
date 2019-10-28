<?php
/*
php/expert-items-grid.php
By Matthew DiMatteo, Children's Technology Review

This file outputs the result items in grid view format for expert reviewers
The variables $array and $numRows must be specified before including this file to refer to:
- $array = the appropriate array of records (containing either expert or student reviewers)
- $numRows = the number of rows to output based on the size of the records array

This file is included in the file 'php/content/content-experts.php'
*/

$e = -1; // counter for array of expert records
for($row = 0; $row < $numRows; $row++)
{
    echo '<div class = "bottom-20">';
        //echo $row;
        for($col = 0; $col < $numCols; $col++)
        {
            $e++; // increment the expert records array counter with each column
            $expert = $array[$e]; // locate the expert record by index number

            require 'php/expert-format.php'; // get dynamic variables created by 'php/get-field.php' and format data

            $expertN = $e + 1;
            if($expertN <= count($array))
            {
                echo '<div class = "inline quarters">';
                    if($expertPhoto != NULL)
                    { 
                        // PHOTO
                        echo '<div class = "expert-photo-grid">';
                            echo '<a href = "'.$expertProfileURL.'">';
                                echo '<img src = "php/img.php?-url='.urlencode($expertPhoto).'">';
                            echo '</a>';
                        echo '</div>';
                    } // end if $expertPhoto
                    else
                    { 
                        // NO PHOTO
                        echo '<div class = "expert-photo-grid">';
                            echo '<div class = "no-photo-container"><div class = "no-photo">Photo not available</div></div>';
                        echo '</div>'; 
                    } // end else !photo

                    // NAME
                    if($expertFullName != NULL)	{ echo '<div class = "expert-name"><a href = "'.$expertProfileURL.'">'.$expertFullName.'</a></div>'; }

                    // JOB/COMPANY
                    if($expertTitleLine != NULL){ echo '<div class = "expert-title">'.$expertTitleLine.'</div>'; }

                echo '</div>'; // /.inline quarters [col]
            } // end if $expertN <= count($array)
        } // end for col
    echo '</div>'; // /.bottom-10 [row]
} // end for row
?>