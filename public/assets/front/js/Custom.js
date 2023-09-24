$(document).ready(function () {


    var swiper = new Swiper('.swiper-container', {
        effect: 'fade',
        loop: true,
        speed: 800,
        autoplay: {
            delay: 1500,
            disableOnInteraction: false,
          },
        
    });



});




$(document).ready(function () {
    $('#dt-filter-select').dataTable({
        "language": {
            "decimal": "",
            "emptyTable": "لا يوجد بيانات",
            // "info": "عرض صفحة PAGE من PAGES صفحات",
            "infoEmpty": "عرض مدخلات من 0 الى 0 ",
            "infoFiltered": "(محدد من MAX عنصر)",
            "infoPostFix": "",
            "thousands": ",",
            // "lengthMenu": "عرض MENU مدخلات بالصفحة",
            "loadingRecords": "...تحميل",
            "processing": "...تنفيذ",
            "search": "ابحث:",
            "zeroRecords": "لا يوجد نتائج للبحث",
            "paginate": {
                "first": "الأول",
                "last": "الأخير",
                "next": "التالى",
                "previous": "السابق"
            },
            // "aria": {
            //     "sortAscending": ": activate to sort column ascending",
            //     "sortDescending": ": activate to sort column descending"
            // }
        },

        //     initComplete: function () {
        //       this.api().columns().every( function () {
        //           var column = this;
        //             var select = $('<select  class="browser-default custom-select form-control-sm"><option value="" selected>Search</option></select>')
        //               .appendTo( $(column.footer()).empty() )
        //               .on( 'change', function () {
        //                   var val = $.fn.dataTable.util.escapeRegex(
        //                       $(this).val()
        //                   );

        //                   column
        //                       .search( val ? '^'+val+'$' : '', true, false )
        //                       .draw();
        //               } );

        //           column.data().unique().sort().each( function ( d, j ) {
        //               select.append( '<option value="'+d+'">'+d+'</option>' )
        //           } );

        //       } );
        //   }
    });

    jQuery('.numbersOnly').keyup(function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });



    // $('.mapView').click(function () {
    //     $('.clint-location').slideToggle('slow');
    // });



    $(document).ready(function () {
        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn'),
            allPrevBtn = $('.prevBtn');
    
        allWells.hide();
    
        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);
    
            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-indigo').addClass('btn-default');
                $item.addClass('btn-indigo');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });
    
        allPrevBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                prevStepSteps = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
    
                prevStepSteps.removeAttr('disabled').trigger('click');
        });
    
        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;
    
            $(".form-group").removeClass("has-error");
            for(var i=0; i< curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }
    
            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
        });
    
        $('div.setup-panel div a.btn-indigo').trigger('click');
    });

    
});
//////////  //////////////////    /////////////

////////////////////////////////////////////////
//////////////////  main  ////////// ///////////
////// ///////////////////////////////////////

//////////////////////////////////  ///////////


$(document).ready(function () {
    //spinner
    $(".spinner ").fadeOut("slow");

    //SmoothScroll js
    var scroll = new SmoothScroll('a[href*="#"]');

    //AOS js
    AOS.init({
        offset: 90, // offset (in px) from the original trigger point
        duration: 500, // values from 0 to 3000, with step 50ms
    });

    //materialSelect
    $('.mdb-select').materialSelect();

    //pickatime
    $('#input_starttime').pickatime({
        twelvehour: true,
    });

    //pickadate
    $('.datepicker').pickadate();

    //toast
    $('.toast').toast('show');

    //tooltip
    $('[data-toggle="tooltip"]').tooltip()

});

// $(window).scroll(function () {
//     var appScroll = $(document).scrollTop();

//     if ((appScroll > 60) && (appScroll < 99999999999)) {
//         $(".navbar").addClass("bg-white");

//     };
//     if ((appScroll > 0) && (appScroll < 60)) {
//         $(".navbar").removeClass("bg-white");
//     };
// });





/*   counter   */


(function ($){
    $.fn.counter = function() {
      const $this = $(this),
      numberFrom = parseInt($this.attr('data-from')),
      numberTo = parseInt($this.attr('data-to')),
      delta = numberTo - numberFrom,
      deltaPositive = delta > 0 ? 1 : 0,
      time = parseInt($this.attr('data-time')),
      changeTime = 10;
      
      let currentNumber = numberFrom,
      value = delta*changeTime/time;
      var interval1;
      const changeNumber = () => {
        currentNumber += value;
        //checks if currentNumber reached numberTo
        (deltaPositive && currentNumber >= numberTo) || (!deltaPositive &&currentNumber<= numberTo) ? currentNumber=numberTo : currentNumber;
        this.text(parseInt(currentNumber));
        currentNumber == numberTo ? clearInterval(interval1) : currentNumber;  
      }
  
      interval1 = setInterval(changeNumber,changeTime);
    }
  }(jQuery));
  
  $(document).ready(function(){
  
    $('.count-up').counter();
    $('.count1').counter();
    $('.count2').counter();
    
    new WOW().init();
    
    setTimeout(function () {
      $('.count5').counter();
    }, 3000);
  });