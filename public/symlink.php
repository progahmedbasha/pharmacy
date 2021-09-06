<?php



$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/storage/app/public';




$sentence = str_replace('/public', '', $targetFolder);




$linkFolder_ = $_SERVER['DOCUMENT_ROOT'].'/storage';


$linkFolder = str_replace('/public','',$linkFolder_);


echo $linkFolder;
die();

symlink($sentence.'/public',$linkFolder);
