<?php
    function FE_CropImage($img, $w=0, $h=0, $a=''){
		/* $a - crop alignment: c, t, l, r, b, tl, tr, bl, br */		
		$q=80; /* calitate 0-100 */		
		$src =__URL__.'app/tt/tt.php?src='.$img.($w>0 ? "&w=$w" : "").($h>0 ? "&h=$h" : "")."&q=$q".(!empty($a) ? "&a=$a" : "");
		return $src;
		
    }
	
?>