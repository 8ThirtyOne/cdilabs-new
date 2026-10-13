<?php
include_once('../../lcmodel/loadPage.inc.php');

use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;

$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$paginUrl = "/news-events/events";
$PageCode = "030102";
$bodyid = "news";
$bodyClass = "clear-header";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'events'");
if (!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$page = $webhelper->RequestFilter("page", 0, false);
$searchYear = $webhelper->RequestFilter("searchYear", 0, false);
if ($webhelper->isNull($page)) $page = 1;
if ($webhelper->isNull($searchYear)) $searchYear = date("Y");
$Parameter = "&searchYear=$searchYear";
$PageSize = 10;
$sql = "SELECT pkid, type, year, startmonth, startday, endmonth, endday, title, eventurl, subtitle, location1, url, body, booth, thumbnail, DATEDIFF(STR_TO_DATE(concat(year, '-', startmonth, '-', startday), '%Y-%m-%d'), CURDATE()) AS diff
    FROM events WHERE status = 1 AND CONCAT(year, '-', endmonth, '-', endday) >= CURDATE() ";
$sql .= "ORDER by year ASC, startmonth ASC, startday ASC";
$PageTitle = 'Events | CDI Labs';
$metaDesc = 'CDI Labs Upcoming Events.';
$PageUrl = 'news-events/events';
$List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$keyword = false;
$keyword = isset($_GET['page']) || isset($_GET['searchYear']) ? true : false;
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <?php
  if (!$keyword) {
    echo "<title>$PageTitle</title>
    <meta name='description' content='$metaDesc' />
    <link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
  }
  if ($keyword) {
    $PageTitle = 'Events - Page ' . $page . ' | CDI Labs';
    $metaDesc = 'CDI Labs Events - Page ' . $page;
    $PageUrl = 'news-events/events?page=' . $page . $Parameter;
    echo "<title>$PageTitle</title>";
    echo "<meta name='description' content='$metaDesc' />";
    echo "<link rel='canonical' href='$webhelper->Domain/$PageUrl' />";
  }
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
  <style>
    .hero-section {
      background-repeat: no-repeat;
      background-position: left top;
      background-size: cover;
    }

    <?php
    if (!empty($hero["desktop"]) && $ext != 'mp4') {
      $desktopImg = $hero["desktop"];
      echo "
    .hero-section{background-image: url('/files/hero/$desktopImg');}";
    }
    if (!empty($hero["mobile"])) {
      $mobileImg = $hero["mobile"];
      echo "@media all and (max-width: 845px) {
    .hero-section{background-image:url('/files/hero/$mobileImg');}";
    }
    ?>
  </style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
<main role="main">
  <section class="hero-section short-hero">
    <div class="page-inner">
      <section class="left-hero-content white-text">
        <h1>Events</h1>
        <h3>Visit us at these upcoming events</h3>
      </section>
  </section>

  <section class="wide-section section-with-sidebar news-section" id="events-section">

    <div class="page-inner">

      <div id="left-sidebar">

        <div class="events-list">

          <div class="events-heading">

            <h3>Upcoming Events</h3>
            <a href="/news-events/past-events">Past Events<svg viewBox="0 0 512 512">
                <path d="M64 256c0 106 86 192 192 192s192-86 192-192S362 64 256 64 64 150 64 256z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M216 352l96-96-96-96" />
              </svg></a>

          </div>

          <?php
          if (!empty($List) && count($List) > 0) {
            foreach ($List as $row) {
              $type = $row['type'];
              $url = $row['eventurl'] == 'none' ? "target='_blank' href='" . $row['url'] . "'" : "href='/event/" . $row['eventurl'] . "'";
              if ($row['type'] == 2 || $row['type'] == 3) {
                $booth = '<span><em>Online</em></span>';
              } else {
                $booth = '<span>Booth <em>' . $row["booth"] . '</em></span>';
              }
          ?>

              <article class="news-article">

                <div class="event-info left">

                  <div class="event-thmb left">
                    <img class="shadow-bg" src="/files/events/<?php echo $row["thumbnail"] ?>" alt="<?php echo $row["title"]; ?>" />
                  </div>

                  <div class="event-title left">
                    <h4><?php echo $row["title"]; ?></h4>
                    <p class="event-sub"><?php echo $webhelper->CurRightString($row["subtitle"], "400"); ?></p>
                    <p class="event-date">
                      <?php
                      $startMonth = $webhelper->GetMonthName($row["startmonth"]);
                      $endMonth = $webhelper->GetMonthName($row["endmonth"]);
                      $startDay = ltrim($row['startday'], '0');
                      $endDay = ltrim($row['endday'], '0');
                      $date = $row["startday"] == $row["endday"] ? $startDay : $startDay . ' - ' . $endDay;
                      if ($row["endmonth"] > $row["startmonth"]) {
                        echo $startMonth . ' ' . $startDay . ' - ' . $endMonth . ' ' . $endDay;
                      } else {
                        echo $startMonth . ' ' . $date;
                      } ?>
                    </p>
                    <p class="event-location1"><?php echo $row["location1"]; ?></p>
                    <p class="event-booth"><?php echo $booth; ?></p>
                  </div>

                </div>

                <div class="event-body left">

                  <?php echo nl2br(stripcslashes($row["body"])); ?>

                </div>

                <?php if (isset($url)) echo "<a class='global-btn blue-btn event-btn smooth-hover'" . $url . ">MORE INFO</a>"; ?>

                <button class="global-btn blue-btn smooth-hover show-event-form" style="cursor: pointer; margin-left:10px;" data-event="<?php echo $row["title"]; ?>">REGISTER FOR EVENT or SCHEDULE A MEETING</button>

              </article>

            <?php
            }
          } else { ?>

            <section class="wide-section">

              <div class="page-inner narrow-section">

                <div class="center-paragraph">
                  <h3>Currently, there are no upcoming CDI Labs events. Please come back later or subscribe below to receive CDI Labs news.</h3>
                </div>

              </div>

            </section>

          <?php } ?>

        </div>

        <section class="wide-section">

          <div class="page-inner">

            <div class="center-paragraph">

              <?php if (!empty($List)) echo $webhelper->GetPageHtml($pageList, $page, $paginUrl, $Parameter, $PageSize); ?>

            </div>

          </div>

        </section>

      </div>

      <aside id="right-sidebar">
        <div class="featured-sidebar">
          <ul id="linkedin-heading">
            <li><img src="/img/common/cdilabs-icon.png" /></li>
            <li><span>CDI LABS</span>Linkedin Feed</li>
          </ul>
          <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
          <div class="elfsight-app-32288ada-f358-4e48-835f-95241787278e" data-elfsight-app-lazy></div>
          <div id="event-form-popup">
            <div id="event-form-content-wrapper">
              <div id="event-form-popup-close"></div>
            <div id="event-form-content">
              <h5>Register for This Event<span class="line-break">OR</span>Schedule a Meeting with Us</h5>
              <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/schedule-meeting-form.php'); ?>
            </div>
            </div>
          </div>

        </div>

      </aside>

      <div id="content-footer"></div>

    </div>

  </section>

</main>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
<script>
  var l = document.querySelectorAll("script[src='https://www.google.com/recaptcha/api.js']").length;
  if (l === 0) {
    var s = document.createElement('script');
    s.src = 'https://www.google.com/recaptcha/api.js';
    s.defer = true;
    document.getElementsByTagName('body')[0].appendChild(s);
  }
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
  const eventsForm = document.getElementById('events-form');
  const formInputs = document.querySelectorAll('#events-form .get-value');
  const submitBtn = document.getElementById('submit-btn');

  const showFormButtons = document.querySelectorAll('.show-event-form');
  showFormButtons.forEach(el => el.addEventListener('click', event => {
    document.getElementById('which-event').value = event.target.dataset.event;
    document.getElementById('which-event').dispatchEvent(new Event('change'));
    document.getElementById('which-event').nextElementSibling.innerHTML = event.target.dataset.event;

    document.getElementById('event-form-popup').classList.add('open');
  }));


  document.getElementById('event-form-popup').addEventListener('click', () => {
    document.getElementById('event-form-popup').classList.remove('open');
  });
  document.getElementById('event-form-popup-close').addEventListener('click', () => {
    document.getElementById('event-form-popup').classList.remove('open');
  });

  document.getElementById('event-form-content').addEventListener('click', (e) => {
    e.stopPropagation();
  });

  eventsForm.addEventListener('submit', async e => {
    let isNotEmpty = true;
    e.preventDefault();
    formInputs.forEach(field => {
      if (field.value.length === 0) {
        field.style.border = '1px solid red';
        isNotEmpty = false;
        if ('whichevent' === field.name) {
          field.nextElementSibling.style.border = '1px solid red';
        }
      }
    });
    let eDiv = document.createElement('div');
    eDiv.setAttribute('id', 'RecaptchaEvents');
    document.getElementById('questions').after(eDiv);
    var widgetE = grecaptcha.render(document.getElementById('RecaptchaEvents'), {
      'sitekey': '6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE',
      'callback': eventsSubmit,
      'size': "invisible"
    });

    if (isNotEmpty) {
      grecaptcha.execute(widgetE);
    } else {
      eDiv.remove();
      grecaptcha.reset(widgetE);
    }
  });

  async function eventsSubmit() {
    const div = document.getElementById('events-form');
    let formTxt = div.getElementsByTagName('p')[0];
    const url = '/support/process-events-form';
    submitBtn.disabled = true;
    submitBtn.style.backgroundColor = '#7c878e';
    if (document.getElementById('form-error')) document.getElementById('form-error').remove();
    let errorBox = document.createElement('p');
    errorBox.setAttribute('id', 'form-error');
    const formData = new FormData(eventsForm);
    try {
      const response = await fetch(url, {
        method: 'post',
        body: formData
      });
      const result = await response.text();
      if (result == 0) {
        if (document.getElementById('RecaptchaEvents')) document.getElementById('RecaptchaEvents').remove();
        const txt = document.createTextNode('Some information is missing. Please check.');
        errorBox.appendChild(txt);
        div.insertBefore(errorBox, eventsForm);
        submitBtn.disabled = false;
        submitBtn.style.backgroundColor = 'transparent';
      } else if (result == 2) {
        if (document.getElementById('RecaptchaEvents')) document.getElementById('RecaptchaEvents').remove();
        const txt = document.createTextNode('Please provide valid email address.');
        errorBox.appendChild(txt);
        div.insertBefore(errorBox, eventsForm);
        submitBtn.disabled = false;
        submitBtn.style.backgroundColor = 'transparent';
      } else if (result == 3) {
        if (document.getElementById('RecaptchaEvents')) document.getElementById('RecaptchaEvents').remove();
        const txt = document.createTextNode("The reCAPTCHA wasn't entered correctly. Please try again.");
        errorBox.appendChild(txt);
        div.insertBefore(errorBox, eventsForm);
        submitBtn.disabled = false;
        submitBtn.style.backgroundColor = 'transparent';
      } else {
        location.href = '/support/meeting-thank-you';
      }
    } catch (error) {
      if (document.getElementById('RecaptchaEvents')) document.getElementById('RecaptchaEvents').remove();
    }
  }
</script>
</body>

</html>