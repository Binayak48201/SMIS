<div class="col-md-12">
  <?php 
  	if($status == 'new'):
 	?>

	 <form class="margin-bottom-40" id="createuser" method="post" action='<?= site_url('theme_option/user_account/insert_user'); ?>' >
      <div class="col-md-4">
          <div class="form-group form-md-line-input">
              <input class="form-control" name='fname' id="opt_fname" required type="text">
              <label >Firstname</label>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group form-md-line-input">
              <input class="form-control" name='lname' id="opt_lname" required type="text">
              <label >Lastname</label>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group form-md-line-input">
              <input class="form-control" name='username' required type="text">
              <label >Username</label>
          </div></div>
          <div class="col-md-4">
           <div class="form-group form-md-line-input">
              
              <select class="form-control" name='usertype'  required>                
              <option value=""></option>
                  <?php
                  foreach ($result as $row) {
                  ?>
                  <option value="<?= $row->ROLE_ID?>"><?= $row->ROLE_NAME ?></option>
                  <?php }?>
              </select>
              <label >User Type</label>
          
      </div>
      </div>
      <div class="col-md-4">
          <div class="form-group form-md-line-input">
              <input class="form-control" name='password' id="pass" required type="password">
              <label >Password</label>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group form-md-line-input">
              <input class="form-control" name='password' id="repass" type="password">
              <label >Re-Type Password</label>
             <!--  <div class="form-control-focus"></div> -->
          </div>
          <span class="error-block label alert-danger" style="display: none;" id='error_pass'>Password doesn't Match</span>
      </div>
      <div class="col-md-4">
          <div class="form-group form-md-line-input">
              <input class="form-control" name='profile_id' value="<?= $profile_id ?>" type="text">
              <label >Profile Id</label>
             <!--  <div class="form-control-focus"></div> -->
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group form-md-radios">
              <label >Account Status</label>
              <div class="md-radio-inline">
                  <div class="md-radio">
                      <input type="radio" id="radio1" name="status" class="md-radiobtn" checked value="ON">
                          <label for="radio1">
                          <span></span>
                          <span class="check"></span>
                          <span class="box"></span>
                          ON </label>
                  </div>
                  <div class="md-radio">
                     <input type="radio" id="radio2" name="status" class="md-radiobtn" value="OFF">
                          <label for="radio2">
                          <span></span>
                          <span class="check"></span>
                          <span class="box"></span>
                          OFF </label>
                  </div>    
              </div>
          </div>
      </div>
      <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
              <button name="submit" value='SUBMIT' class="btn blue" type='submit'>Submit</button>

              <button name="reset"  class="btn red" type='reset'>Reset</button>
          
      </div></div>
  </form>
	<?php
		else:
			?>
			<div class="alert alert-danger">
				User Account Already Exist, <a href="<?= site_url('theme_option/user_account/edit/'.$user->USER_ID)?>">Click Here</a> to edit.
			</div>
			<?php
	 endif; ?>
</div>
<div class="clearfix"></div>