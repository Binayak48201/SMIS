<ul class='menu_list'><?php 
if(isset($result) && !empty($result))
{
	foreach ($result as $row) {
		echo"<a href='".site_url($row->link)."'><li>$row->title</li></a>";
	}
}else
{
	echo'<li>no records</li>';
}
?>
</ul>