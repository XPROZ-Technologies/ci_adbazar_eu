$(document).ready(function () {
    $("body").on("click", ".btn-select-plan", function () {
        var select_plan = $('input[name=bm-plan]:checked').val();
        if (select_plan === "1" || select_plan === "2") {
            $(".notiPopup").fadeOut(5000);
            $('#businessPlan').val(select_plan);
            $('#formSelectPlan').submit();
        } else {
            $(".notiPopup").fadeIn('slow');
            $(".notiPopup .text-secondary").html("Plan does not exist");
            $(".ico-noti-error").removeClass('ico-hidden');
        }
    });
});