<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MainController
 *
 * @author Lateph
 */
class MainController {
	public function actionIndex(){
		$data = $_GET;
		try {
		  $from						= @$data['from'];
		  $profile_image_url 	= @$data['profile_image_url'];
		  $date_twit				= @$data['date_twit'];
		  $content					= @$data['content'];

		  if($from=='' or $profile_image_url=='' or $date_twit=='' or $content==''){
			  throw new Exception('Parameter Tidak Lengkap.');
		  }
	//	  Lateph::app()->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
		  $sql = "INSERT INTO facebook_track
				  VALUES
				  (null,:form,:profile,:date,:content)";
		  $st = Lateph::app()->db->prepare($sql);
		  if($st->execute(array(
				':form'=>$from,
				':profile'=>$profile_image_url,
				':date'=>$date_twit,
				':content'=>$content,
		  ))){
			  echo json_encode(array('status'=>1));
		  } else{
			  throw new Exception('Gagal Menyimpan Didatabase.');
		  } 
	  } catch (Exception $e) {
		  echo json_encode(array('status'=>0,'msg'=>$e->getMessage()));
	  }
	}
}

?>
