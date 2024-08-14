<?php

/**
 * This class is suppose to handle all uploads
 */

 class Uploads{


    public $target_dir = UPLOAD_PATH;
    public $extension;
    public $filename;
    public $templocation;
    public $type = array('xlsx', 'csv');



      //Gets the extension of the file

     /**
      * @return mixed
      */
       public function fileExtension(){
        $this->extension = explode(".", $this->filename['name']);
        $extension = $this->extension = end($this->extension);
        return $extension;
       }


         //Moves  the file from temporary locatio
        public function moveFiles($filename){
            $this->templocation = $this->filename["tmp_name"];
            $extarray = array('jpg','png','jpeg','gif');
            $extension = $this->fileExtension();
            if(in_array($extension,$extarray)){
            move_uploaded_file($this->compressImage($this->templocation,$this->target_dir."/".$filename), $this->target_dir."/".$filename);
            }else{
                move_uploaded_file($this->templocation, $this->target_dir."/".$filename);

            }
        }

         public function upLoadFile($newfilename = null){
             if($newfilename == null){
               $filename =  uniqid().'.'.$this->fileExtension();
             }else{
               $filename =  $newfilename.'.'.$this->fileExtension();
             }
             $this->moveFiles($filename);
             return $successarray = array('status'=>'SUCCESS', 'filename'=>$filename);
         }

        public function removeFile($filename){
            $filepath = UPLOAD_PATH.'/'.$filename;
            unlink($filepath);
        }

        public function compressImage($source_image, $compress_image) {
          $image_info = getimagesize($source_image);	
          if ($image_info['mime'] == 'image/jpeg') { 
              $source_image = imagecreatefromjpeg($source_image);
              imagejpeg($source_image, $compress_image, 30);
          } elseif ($image_info['mime'] == 'image/gif') {
              $source_image = imagecreatefromgif($source_image);
              imagegif($source_image, $compress_image, 30);
          } elseif ($image_info['mime'] == 'image/png') {
              $source_image = imagecreatefrompng($source_image);
              imagepng($source_image, $compress_image, 3);
          }	    
          return $compress_image;
      }
 }


?>
