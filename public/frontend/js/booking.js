var time;
var day;
var month;
var year;
var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var center;

// remove border if the selected date is today's date
function todayEqualActive(){
  setTimeout(function(){
    if($(".ui-datepicker-current-day").hasClass("ui-datepicker-today")){
      $(".ui-datepicker-today")
        .children(".ui-state-default")
        .css("border-bottom", "0");
    }
    else{
      $(".ui-datepicker-today")
        .children(".ui-state-default")
        .css("border-bottom", "2px solid rgba(53,60,66,0.5)");
    }
  }, 20);
}

// call the above function on document ready
todayEqualActive();

$('#calendar').datepicker({
  dateFormat: 'yy-m-d',
  minDate:new Date(),
  inline: true,
  firstDay: 1,
  showOtherMonths: true,
  onChangeMonthYear: function(){
    todayEqualActive();
  },
  onSelect: function(dateText, inst){
    var date = $(this).datepicker().val();
    // day  = date.getDate(),
    // month = date.getMonth() + 1,
    // year =  date.getFullYear(),
    // dayOfWeek = date.getDay();
    // alert(date);
    
    // display day and month on submit button
    // var monthName = months[month - 1];
    // $(".request .day").text(day);
    // $(".request .month").text(monthName );
    // switch (dayOfWeek) {
    //   case 1: dayOfWeek = 'Monday';
    //   break;
    //   case 2: dayOfWeek = 'Tuesday';
    //   break;
    //   case 3: dayOfWeek = 'Wednesday';
    //   break;
    //   case 4: dayOfWeek = 'Thursday';
    //   break;
    //   case 5: dayOfWeek = 'Friday';
    //   break;
    //   case 6: dayOfWeek = 'Saturday';
    //   break;
    //   case 0: dayOfWeek = 'Sunday';
    //   break;
    // }
    // $(".request .dayOfWeek").text(dayOfWeek );

    $(".request .date").text(date);
    $(".request .appointmentDate").val(date);
    
    todayEqualActive();    

    $(".request").removeClass("disabled");
    
    var index;
    
    setTimeout(function(){
       $(".ui-datepicker-calendar tbody tr").each(function(){
        if($(this).find(".ui-datepicker-current-day").length){
          index = $(this).index() + 1;
        }
      });
      
      // insert timepiker placeholder after selected row
      $("<tr class='timepicker-cf'></tr>")
          .insertAfter($(".ui-datepicker")
          .eq(index));
      // var top = $(".timepicker-cf").offset().top - 2;
      

      
    }, 0);
    
    // display time on submit button
    // time = $(".timepicker > div:first-child .owl-stage .active").text() + ":" + $(".timepicker > div:nth-child(2) .owl-loaded .owl-stage .active").text() + ":00";
    // $(".request .time").text(time);
    // $(".request #time").val(time);
    
    // $(".owl-item").removeClass("center-n");
    // center = $(".owl-stage").find(".center");
    // center.prev("div").addClass("center-n");
    // center.next("div").addClass("center-n");
  }
});
// if the inputs arent empty force ":focus state"
$(".form-name input").each(function(){
  $(this).keyup(function() {
    if (this.value) {
      $(this).siblings("label").css({
        'font-size': '0.8em',
        'left': '.15rem',
        'top': '0%'
      });
    }
    // remove force if they're empty
    else{
      $(this).siblings("label").removeAttr("style");
    }
  });
});

// $(".timepicker").on('click', '.owl-next', function(){
//   time = $(".timepicker > div:first-child .owl-stage .active").text() + ":" + $(".timepicker > div:nth-child(2) .owl-loaded .owl-stage .active").text() + ":00";
//   $(".request .time").text(time);
//   $(".request #time").val(time);
  
//   // $(".owl-item").removeClass("center-n");
//   // center = $(".owl-stage").find(".center");
//   // center.prev("div").addClass("center-n");
//   // center.next("div").addClass("center-n");
// });

// $(".timepicker").on('click', '.owl-prev', function(){
//   time = $(".timepicker > div:first-child .owl-stage .active").text() + ":" + $(".timepicker > div:nth-child(2) .owl-loaded .owl-stage .active").text() + ":00";
//   $(".request .time").text(time);
//   $(".request #time").val(time);
  
//   // $(".owl-item").removeClass("center-n");
//   // center = $(".owl-stage").find(".center");
//   // center.prev("div").addClass("center-n");
//   // center.next("div").addClass("center-n");
// });

$('.owl').owlCarousel({
  loop: true,
  items: 1,
  dots: false,
  nav: true,
  mouseDrag: false,
  touchDrag: true,
  responsive: {
    0:{
      items:1
    },
    700:{
      items:1
    },
    1200:{
      items:1
    }
  }
});



// $(window).on('resize', function(){
//   $(".timepicker").css('top', $(".timepicker-cf").offset().top - 2);
// });