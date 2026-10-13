<?php
namespace lcmodel\processDB;

class dbHelper extends keys{
    protected $OK = false;

    public function RunSQLReturnRows($sql){
        $rowList = array();
        try{
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
                $this->throwException($sql);
            }
            $rowcnt = 0;
            while($row = $result->fetch_assoc()){
                $rowList[$rowcnt++] = $row;
            }
            $result->free();
        } catch (Exception $ex) {
            header('Location: /500');
            exit;
        }
        return $rowList;
    }

    public function RunSQLReturnOneRow($query){
        try{
            $select = $this->_conn->query($query);
            if(!$select){
              header('Location: /500');
              exit;
            }
            $rowList = null;
            $rowList = $select->fetch_assoc();
            $select->free();
            return $rowList;
        }catch (Exception $ex) {
            header('Location: /500');
            exit;
        }
    }

     public function RunSQL($sql){
        try{
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
                $this->throwException($sql);
            }
        }catch(Exception $ex){
            header('Location: /500');
            exit;
        }
    }

    public function RunSQLReturnRowsSub($sql, $RequestPage, $PageSize, &$TotalCount){
        $limit = ($RequestPage-1) * $PageSize;
        $sql = preg_replace('/select/i', 'select SQL_CALC_FOUND_ROWS ', $sql, 1);
        $sql = $sql." limit ".$limit.", ".$PageSize;
        $rowList = array();
        try{
            $result = mysqli_query($this->_conn, $sql);
            if (!$result){
                $this->throwException($sql);
            }
            $rowcnt = 0;
            while ($row = $result->fetch_assoc()){
                $rowList[$rowcnt++] = $row;
            }
            $result->free();
            //Get Total Record Count
            $countList = mysqli_query($this->_conn, "select FOUND_ROWS() as cnt;");
            $countRow = $countList->fetch_assoc();
            $TotalCount = $countRow["cnt"];
            $countList->free();
        } catch (Exception $ex) {
            header('Location: /500');
            exit;
        }
        return $rowList;
    }
    
    public function RunSQLReturnID($sql){
        $rowList = null;
        try{
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
               $this->throwException($sql);
            } 
            $sql = "select LAST_INSERT_ID() as pkid";
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
               $this->throwException($sql);
            }
            $rowList = $result->fetch_assoc();
            $result->free();
        } catch (Exception $ex){
            header('Location: /500');
            exit;
        }
        return $rowList["pkid"];
    }
    
    //INSERT DATA WHEN SAFE
    public function insertAll($query){
        $OK = $this->_conn->query($query);         
        return $OK;   
    } 
    public function getLastId(){
       $last = $this->_conn->insert_id;
       return $last;  
    }

    //check if any rows exist when input is safe
    public function safeRows($sql){              
       $seek = $this->_conn->query($sql);
       $num = $seek->num_rows;
       return $num;
    }
    
    //check if any rows exist when input is not safe
	 public function numOfRows($sql, $type, $input){
		$stmt = $this->_conn->stmt_init();
		if($stmt->prepare($sql)){
		  $stmt->bind_param($type, $input);
		  $OK = $stmt->execute();
		  $stmt->store_result();
		  $result = $stmt->num_rows;
		 }
		return $result; 
	 }

     public function selectAll($query){
           try{
             $select = $this->_conn->query($query);
             if(!$select){
                header('Location: /500');
                exit;
               }
             $data = array();
             while($row = $select->fetch_assoc()){
                   $data[] = $row;
                  }
             return $data;
           }
           catch (Exception $ex) {
              header("Location: /500");
              exit;
           }
         }
    
     public function selectOne($query, $type, $input){
	   if($type == '' && $input == ''){
		 return $this->noInput($query);
		}
	   else{
		 return $this->withInput($query, $type, $input);
		}
	  }
	  
	 private function noInput($query){
		$stmt = $this->_conn->stmt_init();
		if($stmt->prepare($query)){
		  $stmt->bind_result($result);
		  $OK = $stmt->execute();
		  $stmt->fetch();
		  $stmt->free_result();
		 }
		return $result;
	   }
   
	 private function withInput($query, $type, $input){
		$stmt = $this->_conn->stmt_init();
		if($stmt->prepare($query)){
		  $stmt->bind_param($type, $input);
		  $stmt->bind_result($result);
		  $OK = $stmt->execute();
		  $stmt->fetch();
		  $stmt->free_result();
		 }
		return $result;
	 }

     public function updateOne($query, $type, $value, $input){ 
       $stmt = $this->_conn->stmt_init(); 
       if($stmt->prepare($query)){
         $stmt->bind_param($type, $value, $input);
         $OK = $stmt->execute();
         $stmt->free_result();
        }
       return $OK;
     }
    	   
     public function updateAll($query){ 
       $OK = $this->_conn->query($query);  
       return $OK;
     }

     public function deleteOne($query, $type, $input){ 
    	$stmt = $this->_conn->stmt_init();           
    	if($stmt->prepare($query))
    	  {   
    	   $stmt->bind_param($type, $input);
    	   $OK = $stmt->execute();
    	  }
    	 return $OK;
     }

     public function deleteAll($query){ 
       $OK = $this->_conn->query($query);  
       return $OK;
     }

    //CUSTOM QUERIES
    public function insertHero($desktop, $orgfilename, $mobile, $page){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO hero_images(status, desktop, orgfilename, mobile, page_name, updatedate, created) 
                    VALUES (0,?,?,?,?, NOW(), NOW())";
        if($stmt->prepare($insert)){
           $stmt->bind_param('ssss', $desktop, $orgfilename, $mobile, $page);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    public function updateHero($desktop, $orgfilename, $mobile, $page, $pkid){
        $stmt = $this->_conn->stmt_init(); 
        $update = "UPDATE hero_images SET desktop = ?, orgfilename = ?, mobile = ?, page_name = ?, updatedate = NOW() WHERE pkid = ?";
        if($stmt->prepare($update)){
           $stmt->bind_param('ssssi', $desktop, $orgfilename, $mobile, $page, $pkid);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    public function cdiSubscriber($first, $last, $email, $status){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO web_subscribers (firstname, lastname, email, status, updated, created) VALUES (?,?,?,?, NOW(), NOW())";
        if($stmt->prepare($insert)){
           $stmt->bind_param('sssi', $first, $last, $email, $status);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    
     public function userIn($id, $pass, $salt, $email){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO member (id, pass, salt, email, status, isAuthenticated, isReader, isAdministrator, isSystemAdmin, isContentAdmin, isEditor, isContentContributor, isNotify) 
                   VALUES (?, ?, ?, ?, '0', '0', '0', '0', '0', '0', '0', '0', '0')";
        if($stmt->prepare($insert)){
           $stmt->bind_param('ssis', $id, $pass, $salt, $email);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    
    public function userAdminIn($id, $pass, $salt, $email, $first, $last, $company, $country, $state, $city, $zip, $phone, $isAdmin, $isEditor, $isHR, $status){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO admin (id, pass, salt, email, firstname, lastname, company, country, providence, city, postcode, phone, isAdministrator, isEditor, isHR, status, updated, regdate, logindate)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), NOW())";
        if($stmt->prepare($insert)){
           $stmt->bind_param('ssisssssssssiiii', $id, $pass, $salt, $email, $first, $last, $company, $country, $state, $city, $zip, $phone, $isAdmin, $isEditor, $isHR, $status);
           $OK = $stmt->execute();
          }
         return $OK;
    }

    public function contactIn($first, $last, $email, $phone, $zip, $company, $occupation, $country, $sample, $foundout, $assay, $inquiry, $platform, $news, $refpage){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO cdivisitor (firstname, lastname, email, phone, zip, company, occupation, country, sample_num, heard_from, assay_goal, inquiry, platform, newsletter, referrer, updated, created, status) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(),NOW(),'0')";
        if($stmt->prepare($insert)){
           $stmt->bind_param('ssssisssissssis', $first, $last, $email, $phone, $zip, $company, $occupation, $country, $sample, $foundout, $assay, $inquiry, $platform, $news, $refpage);
           $OK = $stmt->execute();
          }
         return $OK;
    }

    public function documentIn($data, $thumbnail, $filename, $orgfilename, $permission){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO literatures (type, title, slugurl, body, keywords, month, day, year, thumbnail, filename, orgfilename, permission, status, updatedate, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW(), NOW())";
        if($stmt->prepare($insert)){
          $stmt->bind_param('issssssssssi', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $thumbnail, $filename, $orgfilename, $permission);
          $OK = $stmt->execute();
        }  
        return $OK;
    }
 
    public function publicationIn($data, $thumbnail, $filename, $orgfilename, $slugurl, $permission, $featured){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO publications (title, authors, publisher, institution, link, body, keywords, month, day, year, thumbnail, filename, orgfilename, slugurl, permission, featured, status, updatedate, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW(), NOW())";
        if($stmt->prepare($insert)){
          $stmt->bind_param('ssssssssssssssii', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $thumbnail, $filename, $orgfilename, $slugurl, $permission, $featured);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function newsIn($data, $thumbnail, $filename, $orgfilename, $isSlide){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO articles (month, day, year, source, url, title, subtitle, slugurl, body, thumbnail, filename, orgfilename, type, status, updatedate, created, permission, isSlide) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW(), NOW(), '1', ?)";
        if($stmt->prepare($insert)){
          $stmt->bind_param('ssssssssssssii', $data[7], $data[8], $data[9], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $thumbnail, $filename, $orgfilename, $data[0], $isSlide);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function eventIn($data, $thumbnail, $heroimg, $heromobile, $filename, $orgfilename){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO events (type, startmonth, startday, year, endmonth, endday, title, subtitle, address, location1, url, booth, eventurl, body, thumbnail, heroimg, heromobile, filename, orgfilename, status, updatedate, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?, '0', NOW(), NOW())";
        if($stmt->prepare($insert)){
          $stmt->bind_param('issssssssssssssssss', $data[0], $data[9], $data[10], $data[11], $data[12], $data[13], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $thumbnail, $heroimg, $heromobile, $filename, $orgfilename);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function videoIn($data, $thumbnail){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO videos (type, title, youtube_url, slugurl, body, thumbnail, updated, created, status) VALUES (?,?,?,?,?,?,NOW(),NOW(),0)";
        if($stmt->prepare($insert)){
          $stmt->bind_param('isssss', $data[0], $data[1], $data[2], $data[3], $data[4], $thumbnail);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    //////////// INSERT CMS PAGES ////////////

    public function webPageIn($title, $slugurl, $desc, $cat){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO web_page (title, slugurl, description, cat, updatedate, created, status) VALUES (?,?,?,?,NOW(),NOW(),0)";
        if($stmt->prepare($insert)){
          $stmt->bind_param('ssss', $title, $slugurl, $desc, $cat);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function webPageHeroIn($pageId, $pos, $desktop, $orgfilename, $mobile, $subtitle, $title, $para, $btnText, $btnUrl, $btnTarget){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO web_page_hero (page_id, align, desktop, orgfilename, mobile, subheading, heading, paragraph, btn_text, btn_url, btn_target, updated, created) VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())";
        if($stmt->prepare($insert)){
          $stmt->bind_param('isssssssssi', $pageId, $pos, $desktop, $orgfilename, $mobile, $subtitle, $title, $para, $btnText, $btnUrl, $btnTarget);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function webPageSectionIn($pageId, $align, $bgColor, $colNum, $className, $idName, $bgimg, $bgMobileImg, $heading, $subheading, $section_para, $section_body, $videoImg, $videoImgOrg, $ytVideo, $pos){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO web_page_section (page_id, align, bgColor, numofcols, class_name, id_name, bgimg, bgMobileImg, heading, subheading, section_paragraph, section_body, videoimg, videoimgorgname, ytvideo, position, updatedate, created, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),0)";
        if($stmt->prepare($insert)){
          $stmt->bind_param('ississsssssssssi', $pageId, $align, $bgColor, $colNum, $className, $idName, $bgimg, $bgMobileImg, $heading, $subheading, $section_para, $section_body, $videoImg, $videoImgOrg, $ytVideo, $pos);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function webPageBtnIn($sectionId, $btnClass, $btnId, $btnText, $btnBg, $btnUrl, $btnTarget){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO web_page_btn (section_id, btn_class, btn_id, btn_text, btn_bg, btn_url, btn_target, updatedate, created) VALUES (?,?,?,?,?,?,?,NOW(),NOW())";
        if($stmt->prepare($insert)){
          $stmt->bind_param('isssssi', $sectionId, $btnClass, $btnId, $btnText, $btnBg, $btnUrl, $btnTarget);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function webPageColIn($sectionId, $bg, $content){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO web_page_column (section_id, bgColor, body, updated, created) VALUES (?,?,?,NOW(),NOW())";
        if($stmt->prepare($insert)){
          $stmt->bind_param('iss', $sectionId, $bg, $content);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    //////UPDATE CMS PAGES /////
    public function updateWebPageHero($heroLayout, $newHeroDesktopName, $newHeroOrgName, $newMobileFileName, $heroSubtitle, $heroTitle, $heroParagraph, $heroBtnText, $heroBtnUrl, $heroBtnTarget, $pageId){
        $stmt = $this->_conn->stmt_init(); 
        $update = "UPDATE web_page_hero SET align=?, desktop=?, orgfilename=?, mobile=?, subheading=?, heading=?, paragraph=?, btn_text=?, btn_url=?, btn_target=?, updated = NOW() WHERE page_id = ?";
        if($stmt->prepare($update)){
           $stmt->bind_param('sssssssssii', $heroLayout, $newHeroDesktopName, $newHeroOrgName, $newMobileFileName, $heroSubtitle, $heroTitle, $heroParagraph, $heroBtnText, $heroBtnUrl, $heroBtnTarget, $pageId);
           $OK = $stmt->execute();
          }
         return $OK;
    }

    public function updateWebPageSection($sectionLayout, $sectionBg, $sectionDesktopNewName, $sectionMobileNewName, $sectionHeading, $sectionSubheading, $section_para, $sectionBody, $newVidCustomName, $newVidCustomOrgName, $sectionYouTube, $sectionId){
        $stmt = $this->_conn->stmt_init(); 
        $update = "UPDATE web_page_section SET align=?, bgColor=?, bgimg=?, bgMobileImg=?, heading=?, subheading=?, section_paragraph=?, section_body=?, videoimg=?, videoimgorgname=?, ytvideo=?, updatedate = NOW() WHERE pkid = ?";
        if($stmt->prepare($update)){
           $stmt->bind_param('sssssssssssi', $sectionLayout, $sectionBg, $sectionDesktopNewName, $sectionMobileNewName, $sectionHeading, $sectionSubheading, $section_para, $sectionBody, $newVidCustomName, $newVidCustomOrgName, $sectionYouTube, $sectionId);
           $OK = $stmt->execute();
          }
         return $OK;
    }

    public function updateWebPageBtn($sectionBtnText, $sectionBtnColor, $btnUrl, $btnOutbound, $sectionId, $secBtnId){
        $stmt = $this->_conn->stmt_init(); 
        $update = "UPDATE web_page_btn SET btn_text=?, btn_bg=?, btn_url=?, btn_target=?, updatedate = NOW() WHERE section_id = ? AND pkid = ?";
        if($stmt->prepare($update)){
           $stmt->bind_param('sssiii', $sectionBtnText, $sectionBtnColor, $btnUrl, $btnOutbound, $sectionId, $secBtnId);
           $OK = $stmt->execute();
          }
         return $OK;
    }

     public function updateWebPageColumn($bg, $body, $sectionId, $colId){
        $stmt = $this->_conn->stmt_init(); 
        $update = "UPDATE web_page_column SET bgColor = ?, body=?, updated = NOW() WHERE section_id = ? AND pkid = ?";
        if($stmt->prepare($update)){
           $stmt->bind_param('ssii', $bg, $body, $sectionId, $colId);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    
}
?>
