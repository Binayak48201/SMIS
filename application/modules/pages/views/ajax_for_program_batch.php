<?php
if(!empty($results))
{
   echo'<option value=""> Select Batch</option>';
   foreach($results as $row)
   {    ?>
        <option value="<?=$row->batch_id?>"><?=$row->batch_id?></option>
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
