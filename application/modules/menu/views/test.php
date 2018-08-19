
<?php
//echo modules::run('test/home');


foreach ($result as $value) {
	if($value->parent==0)
	{
		echo $value->title.'<br/>';
		foreach ($result as $loop1) {
			if($loop1->child_level==1 && $loop1->parent==$value->id)
			{
				echo '_'.$loop1->title.'<br/>';
				foreach ($result as $loop2) {
					if($loop2->child_level==2 && $loop2->parent==$loop1->id)
					{
						echo '__'.$loop2->title.'<br/>';
						foreach ($result as $loop3) {
							if($loop3->child_level==3 && $loop3->parent==$loop2->id)
							{
								echo '___'.$loop3->title.'<br/>';
							}
						}
					}
				}
			}
		}
	}
	//echo $value->id;
	# code...
}
?>