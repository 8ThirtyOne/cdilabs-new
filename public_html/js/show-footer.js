document.getElementById('page-footer').classList.replace('hide-section', 'section-fadein');
document.getElementById('page-footer').removeAttribute('data-info');
var sl = document.querySelectorAll("script[src='https://www.google.com/recaptcha/api.js']").length;
if(sl === 0){
    var sc = document.createElement('script');
    sc.src = 'https://www.google.com/recaptcha/api.js';
    sc.defer = true;
    document.getElementsByTagName('body')[0].appendChild(sc);
}
