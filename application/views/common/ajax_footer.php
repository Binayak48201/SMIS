
<script src="<?= site_url('assets'); ?>/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL SCRIPTS -->
<?php
if(isset($addons))
{
  foreach ($addons as $source) 
  {
    echo'<script src="'.$source.'"></script>'."\r\n";
  }
}

?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
  jQuery(document).ready(function() {    
     <?php
      if(isset($addons_load))
      {
        foreach ($addons_load as $loader) 
        {
          echo"{$loader}\r\n";
        }
      }

      ?>

      <?php
      if(isset($script) && $script!=NULL)
      {      
        echo $script;
      }
      ?>
      
  });

  function message_display(type = 'success' , msg = 'default message') {
     $.bootstrapGrowl(msg, {
        ele: 'body', // which element to append to
        type: type, // (null, 'info', 'danger', 'success', 'warning')
        offset: {
            from: 'top', //('top','button')
            amount: 100   // offset height from top
        }, // 'top', or 'bottom'
        align: 'right', // ('left', 'right', or 'center')
        width: 'auto', // (integer, or 'auto')
        delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
        allow_dismiss: true, // If true then will display a cross to close the popup.
        stackup_spacing: 10 // spacing between consecutively stacked growls.
      });
    }
   

  /*
      defining custom header to ajax call for secutity measures
  */

  $.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader('x-my-custom-header', 'ajax-head');
    }
  });

  /*
     for cusrom sctipt
  */
  jQuery.fn.ForceNumericOnly = function()
  {
    return this.each(function()
    {
      //restrict other aplhabet except number
      $(this).keydown(function(e)
      {
          var key = e.charCode || e.keyCode || 0;
          // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
          // home, end, period, and numpad decimal
          return (
              key == 8 || 
              key == 9 ||
              key == 13 ||
              key == 46 ||
              key == 110 ||
              key == 190 ||
              (key >= 35 && key <= 40) ||
              (key >= 48 && key <= 57) ||
              (key >= 96 && key <= 105));
      });
    });
  };

/*
 for ajax theme selection
*/
 
  (function($){
   //load dynamic ajax script from controller
    $('div').on('click', '.edit_opt', function(){
        const data_info = $(this).attr('data-info');
        const data_obj = JSON.parse(data_info);

        for (let key in data_obj) {
          if (data_obj.hasOwnProperty(key)) { 
            if($('#opt_'+key).prop('type') == 'checkbox' && $('#opt_'+key).prop('value') == data_obj[key] )
            { 
              $('#opt_'+key).attr('checked','checked');
              $('#opt_'+key).closest('span').addClass('checked');
            }
            else if($('#opt_'+key).prop('type') == 'checkbox' && $('#opt_'+key).prop('value') != data_obj[key] )
            { 
              $('#opt_'+key).removeAttr('checked');
              $('#opt_'+key).closest('span').removeClass('checked');
            }
            else{
              $('#opt_'+key).val(data_obj[key]);
            }
          }
        }
    });
    
   <?php
  if(isset($ajax_script) && !empty($ajax_script))
  {
    foreach($ajax_script as $ajaxs)
    {
      echo $ajaxs."\n";
    }
  }
  ?>
  })(jQuery);
  
  <?php
    if(isset($jscript) && is_array($jscript) && $jscript!=NULL)
    {      
      foreach ($jscript as $value) {
        echo $value;
      }
    }
   else if(isset($jscript) && $jscript!=NULL)
    {      
      echo $jscript;
    }

    
    ?>
</script>



