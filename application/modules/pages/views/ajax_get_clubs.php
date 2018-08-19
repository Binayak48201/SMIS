<?php
if(!empty($results))
{
   echo'<option value=""> Select Club</option>';
   foreach($results as $row)
   {    ?>
        <option value="<?=$row->club_name?>"><?=$row->club_name?></option>
        <?php
   }
}
else
{
    ?>
<option value=''> (No Records) </option>
    <?php
}
?>
