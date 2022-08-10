
// auto generated side menu from top header menu start
var topHeaderMenu = $('#header nav > ul').clone();
var sideMenu = $('.side-menu-wrap nav');
sideMenu.append(topHeaderMenu);
if ($(sideMenu).find('.sub-menu').length != 0) {
  $(sideMenu).find('.sub-menu').parent().append('<i class="fas fa-chevron-right d-flex align-items-center"></i>');
}
// auto generated side menu from top header menu end

// close menu when clicked on menu link start
// $('.side-menu-wrap nav > ul > li > a').on('click', function () {
//   sideMenuCloseAction();
// });
// close menu when clicked on menu link end

// open close sub menu of side menu start
var sideMenuList = $('.side-menu-wrap nav > ul > li > i');
$(sideMenuList).on('click', function () {
  if (!($(this).siblings('.sub-menu').hasClass('d-block'))) {
    $(this).siblings('.sub-menu').addClass('d-block');
    $(this).css("transform", "rotate(90deg)");
  } else {
    $(this).siblings('.sub-menu').removeClass('d-block');
    $(this).css("transform", "rotate(0deg)");
  }
});
// open close sub menu of side menu end

// side menu close start
$('.side-menu-close').on('click', function () {
  if (!($('.side-menu-close').hasClass('closed'))) {
    $('.side-menu-close').addClass('closed');
  } else {
    $('.side-menu-close').removeClass('closed');
  }
});
// side menu close end

// auto append overlay to body start
$('.wrapper').append('<div class="custom-overlay h-100 w-100"></div>');
// auto append overlay to body end

// open side menu when clicked on menu button start
$('.side-menu-close').on('click', function () {
  if (!($('.side-menu-wrap').hasClass('opened')) && !($('.custom-overlay').hasClass('show'))) {
    $('.side-menu-wrap').addClass('opened');
    $('.custom-overlay').addClass('show');
  } else {
    $('.side-menu-wrap').removeClass('opened');
    $('.custom-overlay').removeClass('show');
  }
})
// open side menu when clicked on menu button end

// close side menu when clicked on overlay start
$('.custom-overlay').on('click', function () {
  sideMenuCloseAction();
});
// close side menu when clicked on overlay end

// close side menu when swiped start
var isDragging = false, initialOffset = 0, finalOffset = 0;
$(".side-menu-wrap")
.mousedown(function(e) {
  isDragging = false;
initialOffset = e.offsetX;
})
.mousemove(function() {
  isDragging = true;
})
.mouseup(function(e) {
  var wasDragging = isDragging;
  isDragging = false;
finalOffset = e.offsetX;
  if (wasDragging) {
      if(initialOffset>finalOffset) {
         sideMenuCloseAction();
         }
  }
});
// close side menu when swiped end


function sideMenuCloseAction() {
  $('.side-menu-wrap').addClass('open');
  $('.wrapper').addClass('freeze');
  $('.custom-overlay').removeClass('show');
  $('.side-menu-wrap').removeClass('opened');
  $('.side-menu-close').removeClass('closed');
  $(sideMenuList).siblings('.sub-menu').removeClass('d-block');
}
// close side menu when clicked on overlay end

// close side menu over 992px start
  $(window).on('resize', function() {
      if($(window).width() >= 992) {
          sideMenuCloseAction();
      }
  })
  // close side menu over 992px end