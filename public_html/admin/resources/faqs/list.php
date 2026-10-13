<?php
include_once('../../../../lcmodel/loadPage.inc.php');
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
            $faqsExists = $dbhelper->numOfRows('SELECT pkid FROM faqs_page WHERE cat = ?', 's', 'faqs');
            if($faqsExists > 0){
                $PageUrl = "/admin/resources/faqs/list";
                $PageCode = "040000";
                $bodyid = 'faqs';
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
                $PageSize = 15;

                $sql = "SELECT pkid, title, slugurl, status, DATE_FORMAT(updated,'%b %d, %Y') AS updated FROM faqs_page";
                if($searchKey != ""){
                    $sql .= " WHERE title LIKE '%$searchKey%' AND cat ='faqs'";
                }else{
                    $sql .=" WHERE cat = 'faqs'";
                }

                if($order == 0)
                    $sql .= " ORDER BY pkid DESC ";

                if( $order == 1)
                    $sql .= " ORDER BY title DESC ";
                if( $order == 2)
                    $sql .= " ORDER BY title ASC ";

                if( $order == 3)
                    $sql .= " ORDER BY updated DESC ";
                if( $order == 4)
                    $sql .= " ORDER BY updated ASC ";

                $List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
                $pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
            }else{
                header('Location: /admin/resources/faqs/errorPage?reason=no-faqs-page-found');
                exit;
            }
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
<?php
    echo "<title>FAQS List Page | CDI Labs</title>";
    include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); 
?> 
<style>
    .display-data col:nth-child(2){width:45%}
    .display-data col:nth-child(3){width:15%}
    .display-data col:nth-child(4){width:10%}
    .display-data col:last-child{width:10%;min-width:100px}
</style>
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
                if(f.order.value == "1"){
                    f.order.value = "2";
                }else{
                    f.order.value = "1";
                }
            }
            if(type == 3){
                if(f.order.value == "3"){
                    f.order.value = "4";
                }else{
                    f.order.value = "3";
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

                <div id="list-heading">
                    <h2>FAQS</h2>
                </div> 

                <div id="search-form">

                    <form name="searchFrm" method="get" action="/admin/resources/faqs/list">
                        <input type="hidden" name="order" value="<?php echo $order; ?>" />
                        <input type="text" name="searchKey" placeholder="Search FAQS" value="<?php echo $searchKey; ?>"> 
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
               <a id="add-new-btn" class="global-btn blue-btn smooth-hover" href="/admin/resources/faqs/pageForm">ADD NEW</a>
               </div>

            </div>

            <form name="ListFrm" id="faqs-form" method="post">
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="cmscat" value="faqs" />

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
                    <th>STATUS</th>
                    <th><a href="javascript:order(3);">LAST UPDATED<?php $show_order = $order == "3" ? "fa-sort-up" : ($order == "4" ? "fa-sort-down" : ""); echo "<i class='fa-solid ".$show_order."'"; ?></a></th>
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
                         $title = $row['title'];
                         $slugurl = $row['slugurl'];
                         $num = $TotalCount - ($i++) - ($PageSize * ($page - 1));
                ?>
                    <tr id="<?php echo 'faqs'.$pkid; ?>">
                        <td class="request-checkboxes"><input type="checkbox" name="pkids[]" id="pkids_<?php echo $row["pkid"]; ?>" value="<?php echo $row["pkid"]; ?>"></td>
                        <td><?php echo "<a class='data-link smooth-hover' href='/admin/resources/faqs/modifyForm?pkid=$pkid&page=$page$Parameter'>$title</a>"; ?></td>
                        <td class="preview-page"><?php echo "<a href='/admin/resources/faqs/preview?slugurl=$slugurl' target='_blank'>Preview Page</a>"; ?>
                        <?php if($row["status"] == 1){
                             $status = "Published";
                             $class="published";
                            }else{
                             $status = "Unpublished"; 
                             $class="unpublished";
                            }
                        ?>
                        <?php echo "<td class='status ".$class."'>".$status."</td>"; ?>
                        <td><?php echo $row["updated"]; ?></td>
                        <td><?php echo "<a class='data-link smooth-hover' href='/admin/resources/faqs/modifyForm?pkid=$pkid&page=$page$Parameter' title='edit'>"; ?><i class="fa-solid fa-edit"></i></a>
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
          <input type="hidden" name="cmscat" value="faqs" />        
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
 var cmsCat = 'faqs';
 var selectBox = $('.select-box');
 $('.select-box .current').click(function(e){
    selectChoice($(this));
    e.preventDefault();
 });

 $(window).click(function(e) {
      var link = $('.select-box li');
      selectBox.each(function(index){
        var box = this.id;
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
        errorLi.text('Must select at least one '+cmsCat+' page.');
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

    $('.status').click(function(e){
      e.preventDefault();
      var getId = $(this).parent().attr('id'); 
      var id = getId.split(cmsCat).pop();
      var getStatus = $(this).attr('class'); 
      getStatus = getStatus.split("status ").pop();
      var status = getStatus == 'unpublished' ? 'publish' : 'unpublish';
      var capitalized = status.charAt(0).toUpperCase() + status.slice(1);
      $.ajax({
           type: 'GET',
           url: '/admin/resources/faqs/'+status+'Page?id='+id+'&cmscat=faqs',
           async : false,
           success: function(result){
            result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(result == "1"){
              $('#'+cmsCat+id+' .status').removeClass(getStatus).addClass(status+'ed');
              $('#'+cmsCat+id+' .status').text(capitalized+'ed');
            }else if(result == "2"){
              alert('FAQS page does not exist.');
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
        var pageName = $('#'+cmsCat+id+' .data-link').text();
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
           url: '/admin/resources/faqs/deletePage',
           data: query,
           async : false,
           success: function(result){
            result = result.replace(/(^\s*)|(\s*$)/ig,'').replace(/\n/ig,'');
            if(result == "1"){
              $('#'+cmsCat+id).fadeOut(function(){
                $(this).remove();
                $.magnificPopup.close();
               });
             }else if(result == "2"){
                alert(cmsCat+' page slugurl not found.');
             }else if(result == "3"){
                alert('Delete Hero Section Failed.');
             }else if(result == "4"){
                alert('Delete FAQS Page table failed.');
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
                if (pkids[i].checked){
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
         url:'/admin/resources/faqs/'+whichPage,
         data:query,
         success:function(data){
           if(data == 0){
               alert('Something went wrong. Try again.');
           }else if(data == 2){
               alert(cmsCat+' page does not exist');
           }else{
              location.href="/admin/resources/faqs/list?page='<?php echo $page.$Parameter; ?>'";
           }
         }
    }); 
}
</script>
</body>
</html>

