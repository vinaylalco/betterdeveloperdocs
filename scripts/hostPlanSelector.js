$(document).ready(function(){

    $('.dropdown').change(function() {
        
        $(".hostPlansWrapper .error").text('');
        var classesToShow = '';
        $('.hostPlanCard').hide();
        var allDropDowns = $(".hostFiltersWrapper select.dropdown");
        
        $(allDropDowns).each(function(){
            // console.log($( this ).val());
            if($( this ).val() != ''){
                classesToShow += '.' + $( this ).val();
            }
        });

        if(classesToShow == ''){
            // this means nothing is selected at all so show all cards
            $('.hostPlanCard').show();
        }else{
            $(classesToShow).show();
            var resultsPresent = false;
            var allHostCards = $(".hostPlansWrapper .hostPlanCard");
            $(allHostCards).each(function(){
                if($( this ).is(':visible')){
                    resultsPresent = true;
                }
            });
            if(!resultsPresent){
                $(".hostPlansWrapper .error").text('No results for your search, please remove or change some of the filters');
            }
        }
        $('.hostFiltersWrapper').scrollView();
        highlightResults();
        
    });

    // clearFilters
    $( ".clearFilters" ).on( "click", function() {
        var allDropDowns = $(".hostFiltersWrapper select.dropdown");
        $(allDropDowns).each(function(){
                $( this ).val('');
        });
        $('.hostPlanCard').show();
        $('.hostFiltersWrapper').scrollView();
    });

    // some useful JS functions
    $.fn.scrollView = function () {
        return this.each(function () {
            $('html, body').animate({
                scrollTop: $(this).offset().top
            }, 1000);
        });
    }

    function highlightResults(){
        var jElement = $('.hostPlansWrapper');
        jElement.addClass('highlight');
        return setTimeout(
            function() { jElement.removeClass('highlight'); },
            2000
        );
    }

    // the sameHeight functions makes all the selected elements of the same height
    $.fn.sameHeight = function() {
        var selector = this;
        var heights = [];

        // Save the heights of every element into an array
        selector.each(function(){
            var height = $(this).height();
            heights.push(height);
        });

        // Get the biggest height
        var maxHeight = Math.max.apply(null, heights);
        // Show in the console to verify
        // console.log(heights,maxHeight);

        // Set the maxHeight to every selected element
        selector.each(function(){
            $(this).height(maxHeight);
        }); 
    };

    $.fn.sameWidth = function() {
        var selector = this;
        var widths = [];

        // Save the widths of every element into an array
        selector.each(function(){
            var width = $(this).width();
            widths.push(width);
        });

        // Get the biggest height
        var maxWidth = Math.max.apply(null, widths);
        // Show in the console to verify
        // console.log(widths,maxWidth);

        // Set the maxWidth to every selected element
        selector.each(function(){
            $(this).width(maxWidth);
        }); 
    };

    $('.dropdown').sameWidth();
    $('.hostPlanImage').sameHeight();
    $('.hostPlanCard').sameHeight();
    // dropdown

    $( ".shopthisplan" ).on( "click", function() {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
        'event': 'wpHostPlanButtonClick'
        });
    });

    // krystal
    $( ".krystal .shopthisplan" ).on( "click", function() {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
        'event': 'wpHostPlanButtonClickKrystal'
        });
    });
});
