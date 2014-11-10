<?php
if(!class_exists('pagination')){
	include_once('pagination.class.php');
}
class ImageSlide
{
    private $wpdb;
	public $countslide=0;
    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }
	public function getCountSlide(){
		if(!$this->contslide){
		$this->countslide = $this->wpdb->get_var("SELECT COUNT(id) FROM front_image_slide");	
		}
		return $this->countslide?$this->countslide:0;
	}
	public function getSlideByID($sid){
		$sliderow = $this->wpdb->get_row("SELECT * FROM front_image_slide WHERE id={$sid}");	
		return $sliderow;
	}
	public function getImageSlide($plimit,$pbegin=0){
		$slideGall = $this->wpdb->get_results("SELECT * FROM front_image_slide ORDER BY sort ASC,update_datetime DESC LIMIT {$pbegin},{$plimit}");
		return $slideGall;
	}
	public function addImageSlide($gtitle='',$glink='',$gsort='',$gimg='',$gdesc=''){
	$qinsert = $this->wpdb->query("INSERT INTO front_image_slide
		( title,description,sort,image_path,create_datetime,update_datetime,publish,link)
		VALUES ( '{$gtitle}','{$gdesc}','{$gsort}','{$gimg}',NOW(),NOW(),'publish','{$glink}' )");
		return $qinsert;
	}
	public function editImageSlide($gid=FALSE,$gtitle='',$glink='',$gsort='',$gimg='',$gdesc=''){
		if($gid){
			$qupdate = $this->wpdb->query("
	UPDATE front_image_slide 
	SET title = '{$gtitle}',description='{$gdesc}',sort='{$gsort}',image_path='{$gimg}',update_datetime=NOW(),link='{$glink}'
	WHERE id = {$gid}
	");
		return $qupdate;
		}else{
			return FALSE;	
		}
	}
	public function delImageSlide($gid,$rdel=FALSE){
		if($gid){
			$this->wpdb->delete( 'front_image_slide', array( 'id' =>$gid ) );
			return TRUE;
		}else{
			return FALSE;	
		}
	}
}