<?php
	if(isset($styles))
	{
	  foreach ($styles as $source) 
	  {
	    echo'<link rel="stylesheet" type="text/css" href="'.$source.'"/>'."\r\n";
	  }
	}
?>
