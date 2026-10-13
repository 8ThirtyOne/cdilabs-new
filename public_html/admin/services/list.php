<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();

if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
     $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
     if(!empty($username)){
        $PageUrl = "/admin/services/";
        $PageCode = "040000";
        $bodyid = "services";
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        if($webhelper->isNull($page)) $page = 1;
        if($webhelper->isNull($searchKey)) $searchKey = "";
        if($webhelper->isNull($order)) $order = 0;
        $Parameter = "&searchKey=$searchKey&order=$order";
        $FirstPageCode = substr($PageCode, 0, 2);
        $SecodeCode = substr($PageCode, 2, 2);
        $ThirdCode = substr($PageCode, 4, 2);

        $Parameter = "&searchKey=$searchKey&order=$order";
        $PageSize = 20;

        $sql = "SELECT pkid, title, status, slugurl, DATE_FORMAT(updatedate,'%b %d, %Y') AS updatedate FROM web_page";
        if($searchKey != ""){
            $sql .= " where title like '%$searchKey%' ";
        }else{
            $sql .= " where cat ='services' ";
        }

        if($order == 0)
            $sql .= " order by pkid desc ";

        if( $order == 1)
            $sql .= " order by title desc ";
        if( $order == 2)
            $sql .= " order by title asc ";

        if( $order == 5)
            $sql .= " order by status desc ";
        if( $order == 6)
            $sql .= " order by status asc ";

        if( $order == 7)
            $sql .= " order by updatedate desc ";
        if( $order == 8)
            $sql .= " order by updatedate asc ";

        $List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
        $pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
        $insert = false;
        $update = false;
        $error = array();
     }else{
       header('Location: /admin/');
       exit;
     }
  }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Admin Services Pages | CDI Labs</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
    <script type="text/javascript">
        function search(){
            document.searchFrm.submit();
        }
        
        function order(type){
            var f = document.searchFrm;

            if(type == 0){
                f.order.value = "0";
            }

            if(type == 1){
                if(f.order.value == "1")
                {
                    f.order.value = "2";
                }else
                {
                    f.order.value = "1";
                }
            }

            if(type == 3){
                if(f.order.value == "3")
                {
                    f.order.value = "4";
                }else
                {
                    f.order.value = "3";
                }
            }

            if(type == 5){
                if(f.order.value == "5")
                {
                    f.order.value = "6";
                }else
                {
                    f.order.value = "5";
                }
            }
            
            if(type == 7){
                if(f.order.value == "7")
                {
                    f.order.value = "8";
                }else
                {
                    f.order.value = "7";
                }
            }
            
            if(type == 9){
                if(f.order.value == "9")
                {
                    f.order.value = "10";
                }else
                {
                    f.order.value = "9";
                }
            }
            
            document.searchFrm.submit();
        }
    </script>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php'); ?> 
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

         <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <div id="search-data">

            <h2>SERVICES PAGES</h2>

            <div id="search-form">
                <form name="searchFrm" method="get" action="/admin/services/list">
                    <input type="hidden" name="order" value="<?php echo $order; ?>"/>
                    <input type="text" name="searchKey" placeholder="Search Services" value="<?php echo $searchKey; ?>"> 
                    <a href="javascript:search();" class="global-btn blue-btn smooth-hover"><i class="fa-solid fa-magnifying-glass"></i></a>
                </form>
            </div>

            <div id="select-users">
                <h4>OPERATIONS</h4>
                <div class="select-box" id="filter">
                    <ul>
                        <li class="current"><a href="0">Choose an operation<i class="fa fa-chevron-circle-down"></i></a></a></li>
                        <li class="choice"><a href="#publishPage">Publish Content</a></li>
                        <li class="choice"><a href="#unpublishPage">Unpublish Content</a></li>
                    </ul>
                </div>

              </div>

              <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = str_replace("-"," ",$error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
              ?>

              <div id="add-new">
               <a id="add-new-btn" class="global-btn blue-btn smooth-hover" href="/admin/services/pageForm">ADD NEW</a>
               </div>

            </div>

            <form name="ListFrm" id="products-form" method="post">
                <input type="hidden" name="page"  value="<?php echo $page; ?>"/>
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>"/>
                <input type="hidden" name="order"  value="<?php echo $order; ?>"/>

            <div class="display-data">

            <table>
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th class="request-checkboxes"><input type="checkbox" name="checkotherall" id="check-all"></th>
                    <th><a href="javascript:order(1);">TITLE<?php $show_order = $order == "1" ? "fa-sort-up" : ($order == "2" ? "fa-sort-down" : ""); echo "<i class='fa-solid ".$show_order."'"; ?></a></th>
                    <th>PREVIEW</th>
                    <th><a href="javascript:order(3);">STATUS<?php $show_order = $order == "3" ? "fa-sort-up" : ($order == "4" ? "fa-sort-down" : ""); echo "<i class='fa-solid ".$show_order."'"; ?></a></th>
                    <th><a href="javascript:order(5);">LAST UPDATED<?php $show_order = $order == "5" ? "fa-sort-up" : ($order == "6" ? "fa-sort-down" : ""); echo "<i class='fa-solid ".$show_order."'"; ?></a></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  if($List != null && count($List) > 0){
                     $num; 
                     $i=0;
                     foreach($List as $row){
                         $pkid = $row['pkid'];
                         $title = $row['title'];
                         $num = $TotalCount - ($i++) - ($PageSize * ($page - 1));
                ?>
                    <tr id="service<?php echo $pkid; ?>">
                        <td class="request-checkboxes"><input type="checkbox" name="pkids[]" id="pkids_<?php echo $row["pkid"]; ?>" value="<?php echo $row["pkid"]; ?>"></td>
                        <td><?php echo "<a class='data-link smooth-hover' href='/admin/services/modifyForm?pkid=$pkid&page=$page$Parameter'>$title</a>"; ?></td>
                        <td class="preview-page"><a href="/admin/services/preview?slugurl=<?php echo $row['slugurl']; ?>" target="_blank">Preview Page</a></td>
                        <?php if($row["status"] == 1){
                             $status = "Published";
                             $class="published";
                            }else{
                             $status = "Unpublished"; 
                             $class="unpublished";
                            }
                        ?>
                        <?php echo "<td class='status ".$class."'>".$status."</td>"; ?>
                        <td><?php echo $row["updatedate"]; ?></td>
                        <td><?php echo "<a class='data-link smooth-hover' href='/admin/services/modifyForm?pkid=$pkid&page=$page$Parameter' title='edit'>"; ?><i class="fa-solid fa-edit"></i></a>
                        <span class="separator"> | </span>
                        <?php echo "<a class='data-link smooth-hover delete-data' href='#$pkid' title='delete'>"; ?><i class="fa-solid fa-trash-can"></i></a></td>
                    </tr>
                <?php
                        }
                    }
                    else{
                ?>
                    <tr>
                        <td colspan="6" align="center">no data found.</td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>

            </form>

            <?php if(count($List) > 0) echo $webhelper->GetAdminPageHtml($pageList, $page, $PageUrl, $Parameter, $PageSize); ?>

            </div>

        </div>

     </div>

     <div class="delete-box mfp-with-anim mfp-hide">
        <form method="post" name="deleteFrm" id="delete-buttons">
          <input type="hidden" name="pkid" id="delete-id" />        
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
 var selectBox = $('.select-box');
 $('.select-box .current').click(function(e){
    selectChoice($(this));
    //stop propagation cause of window click
    e.preventDefault();
 });

 $(window).click(function(e) {
      var link = $('.select-box li');
      selectBox.each(function(index){
        var box = this.id;
        //if clicked anywhere on window but dropbox link
        if(!link.is(e.target)){
           if($('#'+box).height() > 40){
            $('#'+box).animate({
               height: "40px"
              }, {
              duration: 200,
              specialEasing:{
              width: 'linear'
              }
            });
           }
        }
      });
 });

var errorUl = $(document.createElement('ul'));
errorUl.attr('id','display-error');
var errorLi = $(document.createElement('li'));
errorLi.appendTo(errorUl);

 $('.select-box .choice').click(function(e){
    e.preventDefault();
    errorUl.hide();
    if(ischecked()){
      var icon = $(document.createElement('i'));
      icon.attr('class','fa fa-chevron-circle-down');
      var choice = $(this).find('a').attr('href');
      var filter = choice.split("#").pop();
      $('.select-box .current').find('i').remove();
      $('.select-box .current')
       .removeClass('current')
       .addClass('choice')
       .insertAfter($(this));
       $(this).removeClass('choice').addClass('current');
       icon.appendTo('.current a');
       $('.select-box ul').prepend($(this));
       runOperation(filter);
       $('.select-box .current').click(function(event){
         selectChoice($(this));
         event.preventDefault();
       });
     }else{
        errorLi.text('Must select at least one service page.');
        errorUl.fadeIn(function(){
            $(this).insertAfter($('#select-users'));
        });
     }
  });

 function selectChoice(elem){
        var $this = elem;
        var opened = $this.closest('div').find('.select-open').attr('id');
        if(opened){
          $('#'+opened).animate({
             height: "40px"
            }, {
            duration: 200,
            specialEasing:{
            width: 'linear'
            }
          });
          $('#'+opened).removeClass('select-open');
        }
        var id = $this.closest('div').attr('id');
        var dropdownH = $('#'+id)[0].scrollHeight;

        if($('#'+id).height() > 40){
          $('#'+id).animate({
             height: "40px"
            }, {
            duration: 200,
            specialEasing:{
            width: 'linear'
            }
          });
        }else{
          $('#'+id).animate({
             height: dropdownH+'px'
            }, {
            duration: 200,
            specialEasing:{
            width:'linear'
            }
          });
          $('#'+id).addClass('select-open');
        }
   }

    //Change status
    $('.status').click(function(e){
      e.preventDefault();
      var getId = $(this).parent().attr('id'); 
      var id = getId.split("service").pop();
      var getStatus = $(this).attr('class'); 
      getStatus = getStatus.split("status ").pop();
      var status = getStatus == 'unpublished' ? 'publish' : 'unpublish';
      var capitalized = status.charAt(0).toUpperCase() + status.slice(1);
      $.ajax({
           type: 'GET',
           url: '/admin/services/'+status+'Page?id='+id, 
           async : false,
           success: function(result){
            result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(result == "1"){
              $('#service'+id+' .status').removeClass(getStatus).addClass(status+'ed');
              $('#service'+id+' .status').text(capitalized+'ed');
            }else if(result == "2"){
             alert('Service page does not exist.');
            }else{
              alert('Something went wrong. Try again.');
             }
           },
           error:function(XMLHttpRequest, textStatus, errorThrown){
            alert(errorThrown);
           }
       });
    });

    $('.delete-data').click(function(e){
        e.preventDefault();
        var deleteBox = $('.delete-box');
        $('.delete-box h4').remove();
        var href=$(this).attr('href');
        var id = href.split("#").pop();
        $('#delete-id').val(id);
        deleteBox.attr('id',id);
        var pageName = $('#service'+id+' .data-link').text();
        var warning = $(document.createElement('h4'));
        warning.text("Are you sure you want to delete "+pageName);
        warning.insertBefore($('.delete-box #delete-buttons'));
        openDeleteBox(id);
    });

    $('#no-btn').click(function(e){
      $.magnificPopup.close();
    });

    $('#yes-btn').click(function(e){
          var id = $('#delete-id').val();
          var f = $('#delete-buttons');
          var query = f.serializeArray();         
          $.ajax({
           type: 'GET',
           url: '/admin/services/deletePage',
           data: query,
           async : false,
           success: function(result){
            result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(result == "1"){
              $('#service'+id).fadeOut(function(){
                $(this).remove();
                $.magnificPopup.close();
               });
             }
             else if(result == "2"){
                alert('Service Page slugurl not found.');
             }
             else if(result == "3"){
                alert('Delete hero section failed.');
             }
             else if(result == "4"){
                alert('Delete section failed.');
             }
             else if(result == "5"){
                alert('Delete section button failed.');
             }
             else if(result == "6"){
                alert('Delete section column failed.');
             }
             else if(result == "7"){
                alert('Delete Web Page table failed.');
             }else{
                alert('Something went wrong. Try again.');
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

    function openWarningBox(){
        $('.choice').magnificPopup({
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

document.getElementById('check-all').addEventListener("click", function(event) {
  checkall();
});

function checkall(){
    var checkotherall = document.ListFrm.checkotherall;
    var pkids = document.ListFrm["pkids[]"];
    if (pkids != "undefined" && pkids != undefined){
        if (pkids.length != "undefined" && pkids.length != undefined){
            for (i = 0; i < pkids.length; i++){
                if(checkotherall.checked)
                    pkids[i].checked = true;
                else
                    pkids[i].checked = false;
            }
        }else{
            if(checkotherall.checked)
                    pkids.checked = true;
                else
                    pkids.checked = false;
        }
    }
}

function ischecked(){
    var pkids = document.ListFrm["pkids[]"];
    var cnt = 0;
    if(pkids != "undefined" && pkids != undefined){
        if(pkids.length != "undefined" && pkids.length != undefined){
            for(i = 0; i < pkids.length; i++){
                if (pkids[i].checked)
                {
                    cnt++;
                }
            }
        }else{
            if(pkids.checked){
                cnt++;
            }
        }
    }

    if(cnt == 0){
        return false;
    }else{
        return true;
    }
}

function runOperation(val){
    if(ischecked()){
        if(val == 'delete'){
            if(confirm("Are you sure you want to delete this record?")){
               processQuery('delete');
            }
        }else{
          processQuery(val); 
        }

    }
}

function processQuery(whichPage){
    var f = document.ListFrm;
    var data = new FormData(f);
    var query = new URLSearchParams(data).toString();
       $.ajax({
         type:'POST',
         url:'/admin/services/'+whichPage, 
         data:query,
         success:function(data){
           if(data == 0){
               alert('Something went wrong. Try again.');
           }else if(data == -1){
               alert('Service page does not exist');
           }else{
              document.location.href = "/admin/services/list";
           }
         }
    }); 
}
</script>
</body>
</html>

