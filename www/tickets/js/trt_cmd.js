/**
 * Created by Houcem on 20/12/2016.
 */
(function($) {
    $('.confirmation').on('click', function() {
        $('#gears').fadeIn("slow");
        $('.table').fadeOut("slow");
        $a = $(this).parent();
        var url = $a.attr('href');
        $.ajax(url)
            .done(function () {
                $('.alert-success').fadeIn("slow");
                $('#gears').fadeOut("slow");
            })
            .fail(function() {
                $('.alert-danger').fadeIn("slow");
                $('#gears').fadeOut("slow");
            })
        });
    })(jQuery);