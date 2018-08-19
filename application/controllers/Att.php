<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Att extends CI_Controller {

	public function uploadFileV2()
	{
		//$this->load->view('welcome_message');
		$jsonString = file_get_contents("php://input");
		$myFile = "testFile.txt";
		file_put_contents($myFile,$jsonString);
		//echo "20";
		echo "Upload Package 1 Completed!";
	}

	public function checkUploadCount()
	{
		//$this->load->view('welcome_message');
		echo "Total Uploaded error Logs : 1";
	}
}
