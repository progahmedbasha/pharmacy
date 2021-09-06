<?php


namespace App\Http\Traits;


use Faker\Provider\Image;

trait Upload_Files
{



    //---------------Upload Files----------------
    public function uploadFiles($folder_name,$file,$is_updated_file=NULL){
        //upload or update
        $fileNameToStore=null;

        if ($file){
            if ($is_updated_file!=null) {
             //   $fileNameToStore=$is_updated_file;
                \Storage::delete('/public/' .'uploads/'.$is_updated_file);
            }
            $fileName_original =$file->getClientOriginalName();
            $fileNameWithExt =$file->getClientOriginalExtension();
            $fileName = $folder_name.'/'.pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //$ext =$file->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_'.$fileName_original . '_'.time() . '.' . $fileNameWithExt;
            $file->storeAs('public/uploads/', $fileNameToStore);
        }else{
            $fileNameToStore=$is_updated_file;
        }

        return $fileNameToStore!=null?$fileNameToStore:null;
    }//end





}//end trait
