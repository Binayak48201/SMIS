<?php
/**
* prevent form error for Confirm Form Resubmission
*/
class Post_cache_control 
{
	public function Cachecontrol()
	{
		
		header('Cache-Control: no cache'); //no cache
		session_cache_limiter('public'); // works too
  	//session_cache_limiter('private_no_expire'); // works
	}
	
}
