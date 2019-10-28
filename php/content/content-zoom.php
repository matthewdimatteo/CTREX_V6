<?php
if(isset($_GET['id']))
{
	$id 			= test_input($_GET['id']);
	$imageNumber 	= test_input($_GET['image']);
	if($id != NULL and $imageNumber > 0 and $imageNumber < 4)
	{
		require_once 'php/load-review.php';
		$zoomImageVar 		= 'image'.$imageNumber;
		$zoomImageDataVar	= 'image'.$imageNumber.'Data';
		$zoomImage		 	= $$zoomImageVar;
		$zoomImageData 		= $$zoomImageDataVar;
		echo '<div class = "zoom-heading">';
			echo '<a href = "review.php?id='.$id.'">Back to Review</a>';
		echo '</div>';
		if($zoomImageData != NULL and $zoomImageData != '?')
		{
			// SCALE TO FIT
			echo '<div id = "zoom-container-fit">';
				echo '<img src = "php/img.php?-url='.urlencode($zoomImage).'" alt = "Product Image" 
					onclick = "swapItem(\'zoom-container-full\', \'zoom-container-fit\')">';
			echo '</div>'; // /.zoom-container
			
			// FULL SIZE
			echo '<div id = "zoom-container-full">';
				echo '<img src = "php/img.php?-url='.urlencode($zoomImage).'" alt = "Product Image" 
					onclick = "swapItem(\'zoom-container-fit\', \'zoom-container-full\')">';
			echo '</div>'; // /.zoom-container
			
		} // end if image exists
		else 	{ $redirect = 'review.php?id='.$id; require_once 'php/redirect.php'; } // end else if no image
	} // end if id != null and image btwn 1 and 3
	else 		{ require_once 'php/redirect.php'; } // end else if missing param
} // end if isset id
else 			{ require_once 'php/redirect.php'; } // end else if not issed id
?>