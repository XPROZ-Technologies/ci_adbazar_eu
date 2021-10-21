$(document).ready(function () {
    $("body").on("click", ".btn-select-plan", function () {
        var select_plan = $('input[name=bm-plan]:checked').val();
<<<<<<< HEAD
        if (select_plan === "1" ) { //|| select_plan === "2"
            $(".notiPopup").fadeOut(4000);
=======
        if (select_plan === "1" || select_plan === "2") {
            $(".notiPopup").fadeOut(5000);
>>>>>>> 017674b0877a708110077e40876693de419d4a62
            $('#businessPlan').val(select_plan);
            $('#formSelectPlan').submit();
        } else {
            $(".notiPopup").fadeIn('slow');
            $(".notiPopup .text-secondary").html("Plan does not exist");
            $(".ico-noti-error").removeClass('ico-hidden');
        }
    });
});