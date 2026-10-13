<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$OK = false;
if(isset($_GET['dept']) && isset($_GET['name']) && basename($_GET['name']) == $_GET['name']){
  $urlName = trim($_GET['name']);
  $dept = trim($_GET['dept']);
  $id = $dbhelper->selectOne("SELECT pkid FROM $dept WHERE slugurl = ?", 's', $urlName);
  if($id > 0){
    $PageCode = "040102";
    $bodyid = "resources";
    $bodyClass= "full-header";
    $dir = $dept; //for canonical
    if($dept == 'publications'){
       $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT title, body, thumbnail, filename, orgfilename, link, permission FROM publications WHERE pkid = $id AND status = 1");
    }else{
      $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT title, body, thumbnail, filename, orgfilename, permission FROM $dept WHERE pkid = $id AND status = 1");
    }
    if(!empty($ViewData) && count($ViewData) > 0){
       if($ViewData['permission'] == 0){
        if(isset($_SESSION['userin']) && !empty($_SESSION['userin'])){
          $OK = true;
        }else{
          $OK = false;
          header('Location: /user/login');
          exit;
        }
       }
       if($ViewData['permission'] == 1){
         $OK = true;
       }
       if($dept == 'articles'){
         $bodyid = "news";
         $dept = "news";
       } 
       if(array_key_exists('download', $_POST)){
         $webhelper->DownloadFile("/".$dept."/", $ViewData['filename'], $ViewData['orgfilename']);
       }
       $fileType = $webhelper->GetFileType($ViewData["orgfilename"]);
       $FirstPageCode = substr($PageCode, 0, 2);
       $SecodeCode = substr($PageCode, 2, 2);
       $ThirdCode = substr($PageCode, 4, 2);
       $PageTitle = $ViewData['title'].' | CDI LABS';
       $metaDesc = 'View '.$ViewData['title'];
       $PageUrl = 'content/'.$dir.'/'.$urlName;
       if($OK){
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $PageTitle; ?></title>
<meta name="description" content="<?php echo $metaDesc; ?>" />
<link rel="canonical" href="<?php echo $webhelper->Domain.'/'.$PageUrl; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
body{background:#414447}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main" id="pdf-main">

    <?php if(!$detect->isMobile() && $fileType == 'PDF'){ ?>

    <section class="wide-section" id="pdf-header">

      <div id="pdf-header-inner">

        <div id="pdf-buttons">
          <button id="pdf-zoom-in" class="page-btn"><svg viewBox="0 0 480 480"><title>zoom out</title><path d="M220 400l40 0 0-140 140 0 0-40-140 0 0-140-40 0 0 140-140 0 0 40 140 0 0 140z" /></svg></button>
          <button id="pdf-zoom-out" class="page-btn"><svg viewBox="0 0 480 480"><title>zoom out</title><path d="M80 260l320 0 0-40-320 0 0 40z" /></svg></button>
        </div>

        <p id="page-count" class="fade-out"></p>
        <form method="POST" action="" class="pdf-download">
           <?php if($dept == 'publications' && isset($ViewData['link'])) echo "<a href='{$ViewData["link"]}' class='global-btn smooth-hover' target='_blank'>VIEW JOURNAL</a>"; ?>
           <input type="submit" name="download" value="DOWNLOAD FILE" class="download-btn global-btn blue-btn smooth-hover" />
        </form>

      </div>

    </section>

    <section class="wide-section" id="pdf-page">

          <div class="page-inner narrow-section">

              <section class="left-paragraph" id="pdf-wrap">

                   <div id="pdf-viewer"></div>
                   <div id="loader"></div> 
                  
              </section>


          </div>
        
     </section>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.480/pdf.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.480/pdf_viewer.js"></script>
      <script>
      var url = "/files/<?php echo $dept; ?>/<?php echo $ViewData['filename']; ?>";
      var pdfjsLib = window['pdfjs-dist/build/pdf'];
      pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.480/pdf.worker.min.js';
      var loadingTask = pdfjsLib.getDocument(url);
      var pdfDoc = null,
          pageNum = 1,
          pageRendering = false,
          pageNumPending = null,
          scale = 4,
          cntIn = 0;
      function renderPage(num){
        pageRendering = true;
        pdfDoc.getPage(num).then(function(page){
          var viewport = page.getViewport(scale);
          var canvasId = 'pdf-viewer-' + num;
          var viewer = document.getElementById('pdf-viewer');
          var elem = document.createElement('canvas');
          elem.setAttribute('id',canvasId);
          viewer.append(elem);
          var canvas = document.getElementById(canvasId);
          canvas.height = viewport.height;
          canvas.width = viewport.width;
          document.querySelectorAll('#pdf-viewer canvas').forEach( canvasDiv => { 
            canvasDiv.setAttribute('style', `float:left; width:100%`);
          });
          ctx = canvas.getContext('2d');
          var renderContext = {
            canvasContext: ctx,
            viewport: viewport
          };
          var renderTask = page.render(renderContext);
          renderTask.promise.then(function(){
            pageRendering = false;
            document.querySelectorAll('#loader').forEach(l => { 
              l.remove();
            });
            if(pageNumPending !== null){
              renderPage(pageNumPending);
              pageNumPending = null;
            }
          });
        });
      }

      pdfjsLib.getDocument(url).then(function(pdfDoc_){
        pdfDoc = pdfDoc_;
        renderPage(1);
        for(var i = 2; i <= pdfDoc.numPages; i++){
          renderPage(i);
          if(i > 1){
            const headerPara = document.getElementById('page-count');
            headerPara.classList.replace('fade-out','fade-in');
            headerPara.textContent = pdfDoc.numPages+' PAGES';
          }
        }
      });

      var zoomLevel = 1;
      var updateZoom = function(zoom){
         zoomLevel += zoom;
         document.querySelector('#pdf-page .page-inner').setAttribute('style', `transform:scale(`+ zoomLevel + `,` + zoomLevel + `)`);
      }

      var news = 0;
      var ie = 0;
      var oldDiff = 0;
      var currNewsTop = 0;

      document.getElementById('pdf-zoom-in').addEventListener('click', function(e){
          e.preventDefault();
          var newsTop = 0;
          ie = ie - 50;
          if(cntIn < 2){
          document.querySelector('#pdf-zoom-out svg').setAttribute('style', `fill:#0e3455; cursor:pointer;`);
            updateZoom(0.1);
            cntIn++;
            if(cntIn == 2) this.childNodes[0].setAttribute('style', `fill:#bbb; cursor:default;`);
          }
      });

      var oldDiffOut = 0;
      document.getElementById('pdf-zoom-out').addEventListener('click', function(e){
          e.preventDefault();
          if(cntIn > 0){
            document.querySelector('#pdf-zoom-in svg').setAttribute('style', `fill:#0e3455; cursor:pointer;`);
            ie = ie + 50;
            updateZoom(-0.1);
            cntIn--; 
          }
          if(cntIn == 0) this.childNodes[0].setAttribute('style', `fill:#bbb; cursor:default;`);
      });
      </script>

     <?php }

     if($detect->isMobile() || $fileType != 'PDF'){ ?>

      <section class="wide-section no-margin" id="non-pdf-page">

          <div class="page-inner narrow-section">

            <div class="center-paragraph">

              <div class="left-paragraph">

                <img src="/files/<?php echo $dept.'/', $ViewData['thumbnail']; ?>" alt="<?php echo $ViewData['title']; ?>" />
                  
              </div>

              <div class="right-paragraph">

                <h1><?php echo $ViewData['title']; ?></h1>

                <p><?php echo $ViewData['body']; ?></p>

                <form method="POST" action="" class="non-pdf-download">
                   <input type="submit" name="download" value="DOWNLOAD <?php echo strtoupper($fileType); ?> FILE" class="global-btn blue-btn smooth-hover" />
                </form>
                  
              </div>

            </div>

          </div>
        
     </section>

     <?php } ?>

</main>
 
<?php 
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); 
?>

</body>
</html>
<?php 
       }else{
         header('Location: /');
          exit;
       }//OK check
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