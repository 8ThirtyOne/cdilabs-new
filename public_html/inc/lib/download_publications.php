<?php
include_once('../../../lcmodel/loadRegister.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();

if(isset($_GET['pkid']) && basename($_GET['pkid']) == $_GET['pkid']){
   $id = trim($_GET['pkid']);
   $url = $dbhelper->selectOne("SELECT slugurl FROM publications WHERE pkid = ?", 'i', $id);
   if(!empty($url)){
    $ViewData = $dbhelper->selectAll("SELECT pkid, filename, orgfilename, permission FROM publications WHERE status = 1 and slugurl = '$url'");
    if($ViewData != null && count($ViewData) > 0){
       foreach ($ViewData as $row){
        $filename = $row['filename'];
        $orgfilename = $row['orgfilename'];
        $permission = $row['permission'];
       }

        if($permission == 1){
            //public
            if(!$detect->isMobile() && !$detect->isTablet()){
              header("Location: /content/publications/".$url);
              exit;
            }else{
             $webhelper->DownloadFile("/publications/", $filename, $orgfilename);
            }
        }else if($permission == 2){
            //Register if needed
            if($webhelper->isNull($webhelper->GetRegisterInfo())){
                $webhelper->AlertMessageAndGo ("", "/resources/request-publications?pkid=$pkid");
                header('Location: /support/request-publications?'.$id); 
                exit;
            }else{
              if(!$detect->isMobile() && !$detect->isTablet()){
                header("Location: /content/publications/".$url);
                exit;
              }else{
               $webhelper->DownloadFile("/publicationss/", $filename, $orgfilename);
              }
            }
        }else{
            //user if needed
            if($webhelper->isNull($webhelper->GetLoginPkid()))
                $webhelper->AlertMessageAndGo ("", "/user/login");
            else
                $webhelper->DownloadFile("/publications/", $filename, $orgfilename);
        }
    }else{
       header('Location: /404'); 
       exit;
    }
  }else{
    header('Location: /404'); 
    exit;
  }
}else{
    header('Location: /'); 
    exit;
}
?>
