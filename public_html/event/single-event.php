<?php
include_once('../../lcmodel/loadPage.inc.php');

use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;

$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageCode = "030106";
$bodyid = "news";
$bodyClass = "clear-header";
if (isset($_GET['name']) && !empty($_GET['name'])) {
  $getEvent = strtolower($_GET['name']);
  $eventId = $dbhelper->selectOne('SELECT pkid from events WHERE eventurl = ?', 's', $getEvent);
  if ($eventId > 0) {
    $data = $dbhelper->selectAll("SELECT * FROM events WHERE pkid = '$eventId' ORDER BY year DESC");
    foreach ($data as $row) {
      $PageTitle = $row['title'];
      $eventUrl = $row['eventurl'];
      $thumbnail = $row['thumbnail'];
      $heroImg = $row['heroimg'];
      $heroMobile = $row['heromobile'];
      $metaDesc = $row['subtitle'];
      $startMonth = $webhelper->GetMonthShortName($row['startmonth']);
      $endMonth = $webhelper->GetMonthShortName($row['endmonth']);
      $location1 = $row['location1'];
      $url = $row['url'];
      $booth = $row['booth'];
      $body = $row['body'];
    }
    $PageUrl = 'event/' . $eventUrl;
  } else {
    header('Location: /404');
    exit;
  }
} else {
  header('Location: /news-events/events');
  exit;
}
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php echo $PageTitle; ?></title>
  <meta name="description" content="<?php echo $metaDesc; ?>" />
  <link rel="canonical" href="<?php echo $webhelper->Domain . '/' . $PageUrl; ?>" />
  <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
  <style>
    .hero-section {
      background-repeat: no-repeat;
      background-position: left top;
      background-size: cover
    }

    <?php
    if (!empty($heroImg)) {
      echo "
    .hero-section{background-image: url('/files/events/$heroImg');}";
    }
    if (!empty($heroMobile)) {
      echo "@media all and (max-width: 845px) {
    .hero-section{background-image:url('/files/events/$heroMobile');}";
    }
    ?>
  </style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
<main role="main">
  <section class="hero-section short-hero" id="event-page-hero">
    <div class="page-inner">
      <section class="left-hero-content">
        <p>Join Us</p>
        <h1><?php echo $PageTitle; ?></h1>
        <h3>
          <?php
          $Date1 = strtotime(date('Y-m-d', strtotime($row['year'] . '-' . $row["endmonth"] . '-' . $row['endday']))) . ' ';
          $Date2 = strtotime(date('Y-m-d'));
          $isPast = $Date1 < $Date2;
          $startMonth = $webhelper->GetMonthName($row["startmonth"]);
          $endMonth = $webhelper->GetMonthName($row["endmonth"]);
          $startDay = ltrim($row['startday'], '0');
          $endDay = ltrim($row['endday'], '0');
          $date = $row["startday"] == $row["endday"] ? $startDay : $startDay . ' - ' . $endDay;
          if ($row["endmonth"] > $row["startmonth"]) {
            echo $startMonth . ' ' . $startDay . ' - ' . $endMonth . ' ' . $endDay . ', ' . $row['year'];
          } else {
            echo $startMonth . ' ' . $date . ', ' . $row['year'];
          } ?>
        </h3>
        <h4><?php echo $location1 ?></h4>
        <?php
        if ($row['type'] == 2 || $row['type'] == 3) {
          echo "<p id='event-page-booth'><span>ONLINE</span></p>";
        } else {
          echo "<p id='event-page-booth'>Booth <span>$booth</span></p>";
        }
        ?>
      </section>
    </div>
  </section>
  <section class="wide-section section-with-sidebar news-section" id="events-section">
    <div class="page-inner">
      <div id="left-sidebar">
        <div class="news-article" id="event-page">
          <p><?php echo $PageTitle; ?></p>
          <h4><?php echo $metaDesc; ?></h4>
          <div class="event-body">
            <?php echo nl2br(stripcslashes($body)); ?>
          </div>
          <?php if (!$isPast) { ?>
            <button class="global-btn blue-btn smooth-hover show-event-form" style="cursor: pointer;" data-event="<?php echo $row["title"]; ?>">REGISTER FOR EVENT or SCHEDULE A MEETING</button>
          <?php } ?>
        </div>
      </div>
      <aside id="right-sidebar">
        <div class="featured-sidebar">
          <div class="thumb-with-shadow">
            <a href="<?php echo $url; ?>" class="hover-thmb" target="_blank">
              <img id="event-page-thumb" src="/files/events/<?php echo $thumbnail; ?>" alt="<?php echo $PageTitle; ?>" />
              <span class="download-hover"><em>Meeting Website</em></span></a>
          </div>
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