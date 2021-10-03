$(document).ready(function () {
    $("body").on("click", ".btn-select-plan", function () {
        var select_plan = $('input[name=bm-plan]:checked').val();
        if (select_plan === "1" || select_plan === "2") {
            $(".notiPopup").removeClass('show');
            $('#businessPlan').val(select_plan);
            $('#formSelectPlan').submit();
        } else {
            $(".notiPopup").addClass('show');
            $(".notiPopup .text-secondary").html("Plan does not exist");
            $(".ico-noti-error").removeClass('ico-hidden');
        }
    });
});