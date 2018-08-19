   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
	<div class="page-footer">
      <div class="page-footer-inner">
          <?=date('Y')?> &copy; <?=$theme_option->title;?>
      </div>
      <div class="scroll-to-top">
         <i class="icon-arrow-up"></i>
      </div>
   </div>
   <!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>-->
<!--<script src="<?= site_url('assets'); ?>/global/plugins/respond.min.js"></script> --> <!-- to enable responsive web designs in browsers that don't support CSS3 Media Queries -->
<!--<script src="<?= site_url('assets'); ?>/global/plugins/excanvas.min.js"></script> -->
<!--[endif]-->
<script src="<?= site_url('assets'); ?>/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?= site_url('assets'); ?>/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
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
<script src="<?= site_url('assets'); ?>/global/scripts/metronic.min.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/admin/layout2/scripts/layout.js" type="text/javascript"></script>
<script src="<?= site_url('assets'); ?>/admin/layout2/scripts/demo.js" type="text/javascript"></script>

<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <img width='100%' id='model-img' src='' alt='' />
      </div>
    </div>
  </div>
</div>

<a class=" btn default hide" data-toggle="modal" id='initial_reset' href="#static"></a>
<div id="static" class="modal fade" tabindex="-1" data-backdrop="static"  data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/change_password/update'); ?>' role="form" >
        <p class='col-md-offset-3 label label-success'>Please Change Your Default Password </p>
              <div class="form-group form-md-line-input">
                <label for="inputPassword12" class="col-md-4 control-label">New Password</label>
                <div class="col-md-4">
                  <input class="form-control" id="pass" name='new_pass' required placeholder="New Password" type="password">
                  <div class="form-control-focus">
                  </div>
                </div>
              </div>
              <div id='conf-pass' class="form-group form-md-line-input">
                <label for="inputPassword12" class="col-md-4 control-label">Confirm Password</label>
                <div class="col-md-4">
                  <input class="form-control" id="repass" name='re_pass' required placeholder="Confirm Password" type="password">
                  <div class="form-control-focus"></div>
                </div>
                  <span class="error-block label alert-danger" style="display: none;" id='error_pass'>Password doesn't Match</span>
              </div>
              <input class="form-control" id="oldpass" name='old_pass' required value="admin" placeholder="Old Password" type="hidden">
              <div class="form-group">
                <div class="col-md-offset-3 col-md-10">
                  <button name="update"  class="btn blue" type='submit'>Update Password</button>
                </div>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   Demo.init(); // init demo features 
   
   <?php
    if(isset($addons_load))
    {
      foreach ($addons_load as $loader) 
      {
        echo"{$loader}\r\n";
      }
    }

    ?>
});


   
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<script>
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

$(".num_only").ForceNumericOnly();
  /*
  for change password
  */
  (function($){

    $( "#changepass" ).submit(function( e ) {
      //e.preventDefault();
      var pass=$('#pass').val();
      var con_pass=$('#repass').val();
      if(pass==con_pass)
      {
          $( "#changepass" ).submit();
      }
      else
      {
          //alert('not same');
          $( "#conf-pass" ).addClass('has-error');
          $( "#error_pass" ).show();
          return false;
      }
    });

    /*
    for menu icons
     */
    $('.item-ico').click(function(){
      var value=$(this).children('span').attr('class');
      $('#menu-ico').val(value);
      $('#selected_icon').click();
    });

    
   
    <?php
    if(isset($script) && $script!=NULL)
    {      
      echo $script;
    }
    ?>

  })(jQuery);

/*
 for ajax theme selection
*/
 
  (function($){
    $('.theamer').click(function(){
       var option= $(this).attr('data-style');
       $.post( '<?= site_url("pages/theme_option/set_theme"); ?>', 
        {
          option:option,
          user:'<?=$this->session->userdata("smis_role");?>'
        })
        .done(function(result) {
         console.log("successful theme changed");
        })
        .fail(function() {
          console.log("error");
        })
    });
    //popup image model
    $('.pop-img').click(function()
    {
      var src=$(this).attr('data-img-path');
      $('#model-img').attr('src', src);
    });

    //dynamic load table value to model pop up for edit
    $('table').on('click', '.edit_opt', function(){
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
            else
              $('#opt_'+key).val(data_obj[key]);
          }
        }
    });

    //load dynamic ajax script from controller
   <?php
  if(isset($ajax_script) && !empty($ajax_script))
  {
    foreach($ajax_script as $ajaxs)
    {
      echo $ajaxs."\n";
    }
  }
?>
    $('#section_id').change(function()
             {
               $( '#semester' ).trigger( 'change' );
             })

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

<?php // echo modules::run('dashboard/user_log/log');?>

