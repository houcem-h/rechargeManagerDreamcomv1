/**
 * Created by Houcem on 23/12/2016.
 */
(function($) {
    $(document).on('click','.btnDownload',function(evt){
        // $('.btnDownload').on('click', function(btnDownload) {
        evt.preventDefault();
        $('#gears').fadeIn("slow");
        $('fieldset').fadeOut("slow");
        $('#newImpress').fadeOut("slow");
        $a = $(this);
        var url = $a.attr('href');
        $.ajax(url)
            .complete(function () {
                $('fieldset').fadeIn("slow");
                $('#gears').fadeOut("slow");
                $('#newImpress').fadeIn("slow");
            })
    });
})(jQuery);