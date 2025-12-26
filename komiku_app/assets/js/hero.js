document.addEventListener('DOMContentLoaded', function(){
  if (typeof Swiper === 'undefined') return;
  var swiper = new Swiper('.hero-swiper', {
    loop: true,
    autoplay: { delay: 4500, disableOnInteraction: false },
    pagination: { el: '.swiper-pagination', clickable: true },
    effect: 'slide'
  });
});
