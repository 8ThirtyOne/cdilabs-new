'use strict';

let ready = (callback) => {
  if (document.readyState != "loading") callback();
  else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => { 

  const pageId = document.body.id;
  let winWidth = window.innerWidth;
  const mainNav = document.getElementById('main-nav');
  const navBg = document.getElementById('nav-bkg');
  const navClass = mainNav.classList;
  const mainLink = document.querySelectorAll('.main-link');
  const subMenu = document.querySelector('.sub-menu');
  const overlay = document.createElement('div');
  overlay.setAttribute('id', 'overlay');
  const hamburgerBtn = document.getElementById('hamburger-btn');
  const searchBtn = document.getElementById('searchButton');
  const searchBox = document.getElementById('searchBox');

  //---- Underline Current Nav Link ----//
  document.querySelectorAll('.main-link a').forEach((l) => { 
    if(l.parentElement.getAttribute('data-hover') == pageId) l.childNodes[1].style.fill='#346c97';
  });
  let isScrolling = false;
  window.addEventListener('scroll', throttleScroll, false);

  function throttleScroll(){
    if(isScrolling == false){
      requestAnimationFrame(function(){
        let newWidth = window.innerWidth;
        var div = document.querySelectorAll('.hide-section');
        const lazy = new lazyLoad(div);
        lazy.maybeLoad();
        isScrolling = false;
      });
    }
    isScrolling = true;
  }

  if(winWidth > 1551){
     document.querySelectorAll('.main-link').forEach(link => { 
       link.classList.add('desktop-link');
       let dh = link.getAttribute('data-hover');
       link.addEventListener('mouseover', function() { 
          const id = this.childNodes[3].getAttribute('id');
          const subMenuH = outerHeight(document.getElementById(id));
          navBg.style.height = subMenuH + 'px';
       }, false);
     });
     searchBox.classList.remove('hide-it');
  }else{
     navClass.remove('reset-outer-ul');
     mainNav.style.height = '100%';
     document.querySelectorAll('.sub-menu').forEach(sm => { 
       sm.classList.add('slide-up');
     });
     searchBox.classList.add('hide-it');
  }

  function outerHeight(menu) {
    const s = getComputedStyle(menu);
    return (
      menu.getBoundingClientRect().height +
      parseFloat(s.marginTop) +
      parseFloat(s.marginBottom)
    );
  }

  window.addEventListener("resize", function() {
    toggleNav();
  });

  function toggleNav(){
    const navClass = mainNav.classList;
    if(window.innerWidth < 1551){
       navClass.remove('reset-outer-ul');
       mainNav.style.height = '100%';
       document.querySelectorAll('.main-link').forEach(ml => { 
         ml.classList.remove('desktop-link');
       });
       document.querySelectorAll('.sub-menu').forEach(sm => { 
         sm.classList.add('slide-up');
       });
       searchBox.classList.add('hide-it');
       searchBox.classList.add('search-close');
    }else{
       overlay.remove();
       navClass.remove('slide-back');
       navClass.remove('slide-in');
       navClass.add('reset-outer-ul');
       hamburgerBtn.classList.remove('is-active');
       document.querySelectorAll(".main-link").forEach(ml => { 
         ml.classList.add('desktop-link');
         let dh = ml.getAttribute('data-hover');
         ml.addEventListener('mouseover', function() {
           const id = this.childNodes[3].getAttribute('id');
           const subMenuH = outerHeight(document.getElementById(id));
           navBg.style.height = subMenuH + 'px';
         }, false);
       });
       document.querySelectorAll('.sub-menu').forEach(menus => { 
          if(menus.classList.contains('sub-open')){
            menus.classList.remove('sub-open');
            menus.classList.remove('slide-up');
          }
      });
      searchBox.classList.remove('hide-it');
      searchBox.classList.remove('show-it');
    }
  }

  hamburgerBtn.addEventListener('click', function(){
    this.classList.toggle('is-active');
    const newWinWidth = window.innerWidth;
    const box = mainNav.getBoundingClientRect();
    const docElem = document.documentElement;
    const boxLeft = box.left + window.pageXOffset - docElem.clientLeft;
    const searchStyle = searchBox.classList;
    if(searchStyle.contains('show-it')){
      searchStyle.replace('show-it', 'hide-it');
      overlay.remove();
    }
     document.querySelectorAll('.sub-menu').forEach(menus => { 
      if(menus.classList.contains('sub-open')){
        menus.classList.remove('sub-open');
         menus.classList.add('slide-up');
      }
    });
    if(boxLeft == -345){
       mainNav.classList.toggle('slide-in');
    }else{
       mainNav.classList.toggle('slide-back');
    }
  }, false);

 document.querySelectorAll('.main-link').forEach(ml => { 
  ml.childNodes[1].addEventListener('click', function(event){
    const hbStyle = window.getComputedStyle(hamburgerBtn);
    let linkStyle = this.nextElementSibling.classList;
    let menuId = this.nextElementSibling.getAttribute('id');
    if(hbStyle.display === 'none'){
     //normal clicks
    }else{
      if(linkStyle.contains('sub-open')){
        linkStyle.add('slide-up');
        linkStyle.remove('sub-open');
      }else{
        linkStyle.remove("slide-up");
        linkStyle.add('sub-open');
      }
      document.querySelectorAll('.sub-menu').forEach(menus => { 
        if(menus.classList.contains('sub-open') && menuId != menus.getAttribute('id')){
          menus.classList.remove('sub-open');
          menus.classList.add('slide-up');
        }
      });
      event.preventDefault();
    }
  });
 });

  const cdiCa = document.querySelectorAll('.cdi-canada');
  const dialog = document.getElementById("cdi-canada-popup");
  const dialogGo = document.getElementById("cdi-canada-go");
  const dialogClose = document.getElementById("cdi-canada-close");
  cdiCa.forEach(can => {
    can.addEventListener('click',(e) => {
      e.preventDefault();
      document.getElementsByTagName('main')[0].append(overlay);
      dialog.style.display = 'block';
      dialog.style.zIndex = '1001';
      const cdiCaUrl = can.getAttribute('href');
      dialogGo.addEventListener('click',function(){
        location.href = cdiCaUrl;
      });
    });
  });

  dialogClose.addEventListener("click", () => {
    dialog.style.display = 'none';
    overlay.remove();
  });

 //-------------- SHOW SEARCH -----------------

 searchBtn.addEventListener('click', function(){
    const style = window.getComputedStyle(searchBox);
    if(style.display === 'none'){
      const main = document.getElementsByTagName('main')[0];
      main.append(overlay);
      searchBox.classList.replace('hide-it', 'show-it');
      searchBox.classList.replace('search-close', 'search-open');
    }else{
      overlay.remove();
      searchBox.classList.replace('search-open', 'search-close');
      searchBox.classList.replace('show-it', 'hide-it');
    }
  }, false);

  //---------------- FOOTER SUBSCRIBE FORM ------------------//

  const footerForm = document.getElementById('footer-form');
  const footerInputs = document.querySelectorAll('#footer-form .get-value');
  const footerBtn = document.getElementById('subscribe-btn');
  window.subscribeSubmit = subscribeSubmit;

  footerForm.addEventListener('submit', async event => {
    let isNotEmpty = true;
    event.preventDefault();
    footerInputs.forEach(field => {
      if(field.value.length === 0){
        field.style.border = '1px solid red';
        isNotEmpty = false;
      }
    });
     var rDiv = document.createElement('div');
     rDiv.setAttribute('id', 'RecaptchaSubscribe');
     footerForm.append(rDiv);
     var widgetId2 = grecaptcha.render(document.getElementById('RecaptchaSubscribe'), {
      'sitekey' : '6Lf_fFUpAAAAADh3Rv15j-sJD_DZcQsn889qOGtE',
      'callback' : subscribeSubmit,
      'size' : "invisible"
    });

    if(isNotEmpty){
      grecaptcha.execute(widgetId2);
    }else{
      rDiv.remove();
      grecaptcha.reset(widgetId2);
    }
  });

  async function subscribeSubmit(){
      const url = '/support/process-footer-form';
      if(document.getElementById('form-error')) document.getElementById('form-error').remove();
      const formData = new FormData(footerForm);
      try {
        const response = await fetch(url, {
          method: 'post',
          body: formData
        });
        const result = await response.text();

        if(result == 0){
          processError('We have noticed an error. Please try again.');
        }else if(result == 2){
          processError('Please provide a valid email address.');
        }else if(result == 3){
          processError("Email already exists.");
        }else if(result == 4){
          processError("The reCAPTCHA wasn't entered correctly. Please try again.");
        }else{
          location.href = '/support/signup-thank-you';
        }
      } catch (error) {
        if(document.getElementById('RecaptchaSubscribe')) document.getElementById('RecaptchaSubscribe').remove();
      }
  }

  function processError(msg){
    const div = document.getElementById('subscribe-form');
    var errorBox = document.createElement('p');
    errorBox.setAttribute('id', 'form-error');
    let footerTxt = div.getElementsByTagName('p')[0];
    if(document.getElementById('RecaptchaSubscribe')) document.getElementById('RecaptchaSubscribe').remove();
      const txt = document.createTextNode(msg);
      errorBox.appendChild(txt);
      div.insertBefore(errorBox, footerForm);
      footerBtn.disabled = false;
      footerBtn.style.backgroundColor = '#7c878e';
      footerBtn.value = 'SIGN UP';
   }

});

//--------------------- SLIDER CLASS --------------------//

class Slider{

  constructor(boxid, slides, curr, nav, btn, dir, time){
    this.box = boxid;
    this.name = slides;
    this.playing = curr;
    this.navigation = nav;
    this.navbtn = btn;
    this.direction = dir;
    this.t = time;
    this.timeoutId = 0;
  }

  getNextPrev(){
    const activeSlide = document.querySelector(this.playing);
    const activeIndex = this.name.indexOf(activeSlide);
    let next, prev;
    if(activeIndex === this.name.length - 1){
      next = this.name[0];
    }else{
      next = this.name[activeIndex + 1];
    }
    if(activeIndex === 0){
      prev = this.name[this.name.length - 1];
    }else{
      prev = this.name[activeIndex - 1];
    }
    return [next, prev];
  }

  getPos(){
    const activeSlide = document.querySelector(this.playing);
    const activeIndex = this.name.indexOf(activeSlide);
    const [next, prev] = this.getNextPrev();
    if(this.direction == 'fade'){
        this.name.forEach((slide, index) => {
        const slideClass = slide.classList;
        if(!slideClass.contains('fade-out')) slideClass.add('fade-out');
        if(index === activeIndex){
          slide.classList.replace('fade-out', 'fade-in');
        }else if(slide === prev){
          slide.classList.replace('fade-in', 'fade-out');
        }else if(slide === next){
          slide.classList.replace('fade-in', 'fade-out');
        }else{
          slide.classList.replace('fade-in', 'fade-out');
        }
        slide.addEventListener('animationend', () => {
          slide.classList.remove('swap');
        });
      });
    }
    else if(this.direction == 'horizontal'){
      slides.forEach((slide, index) => {
        const slideClass = slide.classList;
        if (index === activeIndex) {
          if(!slideClass.contains('slider-right')) slideClass.add('slider-right');
          slideClass.replace('slider-right', 'slider-zero');
        } else if (slide === prev) {
          if(!slideClass.contains('slider-zero')) slideClass.add('slider-zero');
          slideClass.add('slider-zero');
          slideClass.replace('slider-zero', 'slider-left');
        } else if (slide === next) {
          if(!slideClass.contains('slider-left')) slideClass.add('slider-left');
          slideClass.add('slider-left');
          slideClass.replace('slider-left', 'slider-right');
        } else {
           if(!slideClass.contains('slider-left')) slideClass.add('slider-left');
          slideClass.add('slider-left');
          slideClass.replace('slider-left', 'slider-right');
        }
        slide.addEventListener('transitionend', () => {
          slide.classList.remove('swap');
        });
      });
    }
  }

  setArrows(){
    for(let i = 0;i<2;i++){
      var div = document.createElement("div");
      div.classList.add("slider-arrow");
      var dir = i == 0 ? 'prev-arrow' : 'next-arrow';
      div.classList.add(dir);
      this.navigation.after(div);
    } 
  }

  getArrows(){
    document.querySelectorAll(this.box+' .slider-arrow').forEach((arr) => {
      arr.addEventListener("click", () => {
        if (arr.classList.contains("next-arrow")) this.getNext();
        else if (arr.classList.contains("prev-arrow")) this.getPrev();
      });
    });
  }

  getNext(){
    clearInterval(this.timeoutId);
    const current = document.querySelector(this.playing);
    const [next, prev] = this.getNextPrev();
    current.classList.add("swap");
    next.classList.add("swap");
    current.classList.replace('fade-in', 'fade-out');
    current.classList.remove("playing");
    next.classList.replace('fade-out', 'fade-in');
    next.classList.add("playing");
    this.getPos();
    this.currNavBtn();
    this.playLoop();
  }

  getPrev(){
    clearInterval(this.timeoutId);
    const current = document.querySelector(this.playing);
    const [next, prev] = this.getNextPrev();
    current.classList.add("swap");
    prev.classList.add("swap");
    current.classList.replace('fade-in', 'fade-out');
    current.classList.remove("playing");
    prev.classList.replace('fade-out', 'fade-in');
    prev.classList.add("playing");
    this.getPos();
    this.currNavBtn();
    this.playLoop();
  }

  setNav(){
    this.name.forEach((slide) => {
      const div = document.createElement("div");
      div.classList.add("slide-btn");
      this.navigation.appendChild(div);
    });
  }

  processNav(){
    document.querySelectorAll(this.navbtn).forEach((btn, i) => {
      btn.addEventListener("click", () => {
        this.getNav(i);
      });
    });
  }

  getNav(i) {
    clearTimeout(this.timeoutId);
    this.name.forEach((slide) => {
      slide.classList.remove("playing");
    });
    const current = this.name[i];
    current.classList.add("playing");
    this.getPos();
    this.currNavBtn();
    this.playLoop();
  }
   
  currNavBtn(){
    const navBtn = document.querySelectorAll(this.navbtn);
    navBtn.forEach((dot) => {
      dot.classList.remove("playing");
    });
    const activeSlide = document.querySelector(this.playing);
    const activeIndex = this.name.indexOf(activeSlide);
    navBtn[activeIndex].classList.add("playing");
    return activeSlide;
  }

  playLoop(){
    this.timeoutId = setTimeout(() => {
      this.getNext();
    }, this.t);
  }

  pauseLoop(){
     clearTimeout(this.timeoutId);
     return document.querySelector(this.playing);
  }

}

//------------------ PROCESS LAZY LOADING ------------------//

class lazyLoad{
 constructor(div){
   this.div = div;
 }

 maybeLoad(){
   const elem = this.div;
   const l = elem.length;
   for(let i=0;i<l;i++){
    let divId = elem[i].getAttribute('id');
    let div = document.getElementById(divId);
    let dataName = div.dataset.info;
    if(dataName == 'lazy-load' && this.inView(div)){
      var len = document.querySelectorAll("script[src='https://www.google.com/recaptcha/api.js']").length;
      if(len === 0){
        if(divId == 'contact-form-section' || divId == 'page-footer'){
          var sc = document.createElement('script');
          sc.src = 'https://www.google.com/recaptcha/api.js';
          sc.defer = true;
          document.getElementsByTagName('body')[0].appendChild(sc);
        }
      }
      div.classList.replace('hide-section', 'section-fadein');
      div.removeAttribute('data-info');
      var img = div.querySelectorAll('.lazy');
      if(img){
        for(var j = 0;j < img.length;j++){
           img[j].srcset = img[j].dataset.lazy;
           img[j].src = img[j].dataset.lazy;
           img[j].removeAttribute('data-lazy');
           img[j].removeAttribute('width');
           img[j].removeAttribute('height');
        }
      }
      var ytvid = div.querySelectorAll('.iframe-video');
      if(ytvid){
        ytvid.forEach((iv, k) => {
            let vidId = iv.getAttribute('data-src');
            let sectionVid = document.createElement('iframe');
            sectionVid.setAttribute('width', '100%');
            sectionVid.setAttribute('height', '100%');
            sectionVid.setAttribute('frameborder', '0');
            sectionVid.setAttribute('src', 'https://www.youtube.com/embed/'+vidId+'?enablejsapi=1&origin=https://www.cdilabs.com');
            ytvid[k].removeAttribute('data-src');
            iv.prepend(sectionVid);
        });
      }
    }
   }
 }

 inView(elem){
  if(typeof pageYOffset != 'undefined'){
    var view_top = pageYOffset;
  }else{
    const B = document.body; 
    const D = document.documentElement; 
    D = (D.clientHeight) ? D : B;
    var view_top =  D.scrollTop;
  }
  const view_bottom = view_top + window.innerHeight + 100;
  const height = elem.offsetHeight;
  const top = this.getTop(elem);
  const bottom = top + height;
  return (height > 0) && (top <= view_bottom) && (bottom >= view_top);
 }

 getTop(el){
    const de = el;
    const box = el.getBoundingClientRect();
    const top = box.top + window.pageYOffset - de.clientTop;
    return top;
 }

}
