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
    $PageUrl = "/admin/manager/list";
    $PageCode = "000000";
    $bodyid = "manager";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
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
<title>Minfy Css | CDI Labs US ADMIN PORTAL</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?>
<style>
#enter-data{width:100%}
#minified-css{height:500px}
#copy-btn{float:right;margin-block:15px}
#copy-btn i{font-size:20px;color:#346c97}</style> 
<script src="https://cdn.jsdelivr.net/npm/csso/dist/csso.js"></script>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>MINIFY CSS</h2>

            <form method="post" name="minifyFrm" id="enter-data">

            <fieldset id="field-one">
                <input type="hidden" name="type" id="type" value="" />
                <div id="select-type">
                <div class="select-box" id="filter">
                  <ul>
                    <li class="current" id="select-css"><a href="#">Select CSS<i class="fa fa-chevron-circle-down"></i></a></a></li>
                    <li class="choice"><a href="#global.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/global.css'); ?>">global.css</a></li>
                    <li class="choice"><a href="#main.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/main.css'); ?>">main.css</a></li>
                    <li class="choice"><a href="#applications.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/applications.css'); ?>">applications.css</a></li>
                    <li class="choice"><a href="#company.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/company.css'); ?>">company.css</a></li>
                    <li class="choice"><a href="#news.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/news.css'); ?>">news.css</a></li>
                    <li class="choice"><a href="#products.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/products.css'); ?>">products.css</a></li>
                    <li class="choice"><a href="#resources.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/resources.css'); ?>">resources.css</a></li>
                    <li class="choice"><a href="#services.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/services.css'); ?>">services.css</a></li>
                    <li class="choice"><a href="#support.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/css/support.css'); ?>">support.css</a></li>
                  </ul>
                </div>
              </div>
            </fieldset>

            <fieldset>
                 <a href="#" id="copy-btn"><i class="fa-solid fa-clone"></i></a>
                 <label for="minified-css"><span>*</span>Minified Css</label>
                   <textarea readonly name="minified-css" id="minified-css" rows="1" cols="1" minlength="10" tabindex="2"></textarea>
            </fieldset>

        </form>

    </div>
    <!-- Page Inner -->

</section>

</main>
<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
<script>
const folder = '<?php echo $_SERVER['DOCUMENT_ROOT']; ?>';

function readTextFile(file) {
  var rawFile = new XMLHttpRequest();
  var cssRaw = '';
  rawFile.open("GET", file, false);
  rawFile.onreadystatechange = function () {
    if(rawFile.readyState === 4)  {
      if(rawFile.status === 200 || rawFile.status == 0) {
        cssRaw = rawFile.responseText;
       }
    }
  }
  rawFile.send(null);
  return cssRaw;
}

$(function(){
 $('#submit-btn').click(function(e){
     e.preventDefault();
     var isValid = true;
     var regField = [];
     $.each($('.get-value'),function(){
       regField.push($('#'+this.id).val());
         if($('#'+this.id).val() === ''){
           $(this).css('border','1px solid red');
           isValid = false;
         }
     });
     if(isValid){
       var f = document.regFrm;
       f.submit();
     }
 });
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

 $('.select-box .choice').click(function(e){
    e.preventDefault();
    var icon = $(document.createElement('i'));
    icon.attr('class','fa fa-chevron-circle-down');
    var choice = $(this).find('a').attr('href');
    var filter = choice.split("#").pop();
    $('#type').val(filter);
    console.log(filter);
    let cssFile = readTextFile('/css/'+filter);
    let result = csso.minify(cssFile);
    $('#minified-css').val(result.css);
    $('.select-box .current').find('i').remove();
    $('.select-box .current')
     .removeClass('current')
     .addClass('choice')
     .insertAfter($(this));
     $(this).removeClass('choice').addClass('current');
     icon.appendTo('.current a');
     $('.select-box ul').prepend($(this));
     $('.select-box .current').click(function(event){
       $('#select-css').remove();
       selectChoice($(this));
       event.preventDefault();
     });
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
});

$('#copy-btn').click(function(e){
 e.preventDefault();
 copyCss();
})

function copyCss(){
  var copyText = document.getElementById("minified-css");
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices
  navigator.clipboard.writeText(copyText.value);
}
</script>
</body>
</html>