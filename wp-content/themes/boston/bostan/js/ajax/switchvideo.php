<?php
if(isset($_POST['prov']) && isset($_POST['vid'])) {
	$vid = $_POST['vid'];
    $prov = $_POST['prov'];
	
	if ($prov == 'youtube') {
		?>
		<iframe class="video_iframe" src="http://www.youtube.com/embed/<?php echo $vid; ?>" frameborder="0" allowfullscreen></iframe>
		<?php
	}elseif ($prov == 'youtu') {
		?>
		<iframe class="video_iframe" src="http://www.youtube.com/embed/<?php echo $vid; ?>" frameborder="0" allowfullscreen></iframe>
		<?php
	}elseif ($prov == 'vimeo') {
		?>
		<iframe class="video_iframe" src="http://player.vimeo.com/video/<?php echo $vid; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		<?php
	}else{
	
	}

}else{
	 echo "error2"; 
}