<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    $input = $webhelper->RequestFilter('user', 255, false);
    $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
    if(!empty($username)){
        if(isset($_GET['category']) && !empty($_GET['category'])){
            $cmscat = $webhelper->RequestFilter("category", 50, false);
            $catExists = $dbhelper->numOfrows('SELECT pkid FROM web_page WHERE cat=?', 's', $cmscat);
            if($catExists > 0){
               $cmsTitle = strtoupper($cmscat);
               $cat = $cmscat == 'promo' ? 'promotions' : $cmscat;
               $PageUrl = "/admin/cmsmodel/leads-module/leads";
               $PageCode = "000000";
               $bodyid = $cmscat;
               $page = $webhelper->RequestFilter("page", 0, false);
               $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
               $order = $webhelper->RequestFilter("order", 0, false);
               if($webhelper->isNull($page)) $page = 1;
               if($webhelper->isNull($searchKey)) $searchKey = "";
               if($webhelper->isNull($order)) $order = 0;
               $Parameter = "&category=$cmscat&searchKey=$searchKey&order=$order";
               $PageSize = 20;
               $sql = "SELECT pkid, firstname, lastname, company, referrer, page_id, DATE_FORMAT(created,'%b %d, %Y') AS created FROM cdivisitor WHERE category = '$cat' UNION 
                SELECT pkid, firstname, lastname, company, referrer, page_id, DATE_FORMAT(created,'%b %d, %Y') AS created FROM promotion_leads WHERE category = '$cat' ";
                if($searchKey != ""){
                    $sql .= " and (company like '%$searchKey%' OR firstname like '%$searchKey%' OR lastname like '%$searchKey%' )";
                }
                if($order == 0) $sql .= " ORDER BY created DESC";
                if( $order == 1)
                    $sql .= " ORDER BY firstname DESC, lastname DESC";
                $List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
                $pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
                $FirstPageCode = substr($PageCode, 0, 2);
                $SecodeCode = substr($PageCode, 2, 2);
                $ThirdCode = substr($PageCode, 4, 2);
            }else{
                header('Location: /admin/cmsmodel/errorPage?reason=no-cms-category-found');
                exit;
            }
        }else{
           header('Location: /admin/cmsmodel/errorPage?reason=no-cms-category-found');
           exit; 
        }
    }else{
        header('Location: /admin/');
        exit;
    }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<?php 
echo "<title>$cmsTitle Leads | CDI Labs</title>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
 <script type="text/javascript">
        function search(){
            document.searchFrm.submit();
        }
        
        function order(type){
            var f = document.searchFrm;

            if(type == 0)
            {
                f.order.value = "0";
            }

            if(type == 1)
            {
                if(f.order.value == "1")
                {
                    f.order.value = "2";
                }else
                {
                    f.order.value = "1";
                }
            }
            
            document.searchFrm.submit();
        }
    </script>
    
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

         <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <div id="search-data">

            <div id="search-form">

                <div id="list-heading">
                    <h2><?php echo $cmsTitle; ?> LEADS</h2>
                    <a href="/admin/cmsmodel/leads-module/export-leads?category=<?php echo $cmscat; ?>" class="smooth-hover">Export Data<svg viewBox="0 0 24 24" fill="#e8eaed"><g><rect fill="none" height="24" width="24"/></g><g><path d="M18,15v3H6v-3H4v3c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-3H18z M17,11l-1.41-1.41L13,12.17V4h-2v8.17L8.41,9.59L7,11l5,5 L17,11z"/></g></svg></a>
                </div>

                <form name="searchFrm" method="get" action="/admin/cmsmodel/leads-module/leads">
                    <input type="hidden" name="order" value="<?php echo $order; ?>" />
                    <input type="hidden" name="category" value="<?php echo $cmscat; ?>" />
                    <input type="text" name="searchKey" value="<?php echo $searchKey; ?>" /> 
                    <a href="javascript:search();" class="global-btn blue-btn smooth-hover"><i class="fa-solid fa-magnifying-glass"></i></a>
                </form>
            </div>

            </div>

            <div class="display-data" id="user-data">

            <table id="visitor-data">
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th><a href="javascript:order(1);">Name</th>
                    <th>Organization</th>
                    <th>Date</th>
                    <th>Referrer</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  if(!empty($List) && count($List) > 0){
                     $num; 
                     $i=0;
                     foreach($List as $row){
                         $pkid = $row['pkid'];
                         $pageId = $row['page_id'];
                         $fullname = $row['firstname'].' '.$row['lastname'];
                         $num = $TotalCount - ($i++) - ($PageSize * ($page - 1));
                ?>
                    <tr id="leads<?php echo $pkid; ?>">
                        <td><?php echo "<a class='data-link smooth-hover' href='/admin/cmsmodel/leads-module/modifyLead?pkid=$pkid&category=$cmscat&pageid=$pageId&page=$page$Parameter'>$fullname</a>"; ?></td>
                        <td class="visitor-company"><?php echo $row["company"];; 
                            ?></td>
                        <td><?php echo $row["created"]; ?></td>
                        <td><?php echo $row['referrer']; ?></td>
                        <td><?php echo "<a class='data-link smooth-hover' href='/admin/cmsmodel/leads-module/modifyLead?pkid=$pkid&category=$cmscat&pageid=$pageId&page=$page$Parameter' title='edit'>"; ?><i class="fa-solid fa-edit"></i></a><span class="separator"> | </span><?php echo "<a class='data-link smooth-hover delete-data' href='#$pkid-$pageId' title='delete'>"; ?><i class="fa-solid fa-trash-can"></i></a></td>
                    </tr>
                <?php
                        }
                    }else{
                ?>
                    <tr>
                        <td colspan="6" align="center">no data found.</td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>

            <?php if(count($List) > 0) echo $webhelper->GetAdminPageHtml($pageList, $page, $PageUrl, $Parameter, $PageSize); ?>

            </div>

        </div>

     <div class="delete-box mfp-with-anim mfp-hide">
        <form method="post" name="deleteFrm" id="delete-buttons">
          <input type="hidden" name="pkid" id="delete-id" />
          <input type="hidden" name="pageid" id="delete-page-id" /> 
          <input type="hidden" name="cmscat" value="<?php echo $cmscat; ?>" />        
          <input type="submit" name="create" value="YES" class='global-btn blue-btn smooth-hover' id="yes-btn" tabindex="1" />
          <button class='global-btn' id="no-btn">NO</button>
         </form>
      </div>

      </div>

    </section>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
<script>
$(function(){
    $('.delete-data').click(function(e){
        e.preventDefault();
        var deleteBox = $('.delete-box');
        $('.delete-box h4').remove();
        var href=$(this).attr('href');
        var getId = href.split("#").pop();
        var idPart = getId.split("-");
        $('#delete-id').val(idPart[0]);
        $('#delete-page-id').val(idPart[1]);
        deleteBox.attr('id',idPart[0]+'-'+idPart[1]);
        var username = $('#leads'+idPart[0]+' .data-link').text();
        var warning = $(document.createElement('h4'));
        warning.text("Are you sure you want to delete "+username);
        warning.insertBefore($('.delete-box #delete-buttons'));
        openDeleteBox(idPart[0]);
    });

    $('#no-btn').click(function(e){
      $.magnificPopup.close();
    });

    $('#yes-btn').click(function(e){
          var id = $('#delete-id').val();
          var f = $('#delete-buttons');
          var query = f.serializeArray();          
          $.ajax({
           type: 'POST',
           url: '/admin/cmsmodel/leads-module/deleteLead', 
           data: query,
           success: function(data){
            if(data == 0){
              alert('Something went wrong. Try again');
             }
            else{
              $('#leads'+id).fadeOut(function(){
                $(this).remove();
                $.magnificPopup.close();
               });
             }
           },
           error:function(XMLHttpRequest, textStatus, errorThrown){
            alert(errorThrown);
           }
        });
        return false;
    });

    function openDeleteBox(id){
        $('.delete-data').magnificPopup({
           removalDelay:700,
           mainClass:'mfp-zoom-in',
           modal: true,
           callbacks:{
            open:function(){
                 $('html').css({'padding':'0','margin':'0'});
                 $('body').css({'padding':'0','margin':'0'});
            }
           }
        });
    }
});
</script>
</body>
</html>
