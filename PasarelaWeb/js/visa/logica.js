$(function () {
//    $('#form_visa').submit();

    $('.modal-opener').click();
    $("body").queryLoader2({
        barColor: "#555566",
        backgroundColor: "#fff",
        percentage: true,
        barHeight: 1,
        completeAnimation: "grow",
        minimumTime: 100,
        onLoadComplete: hidePreLoader
      });
      
      function hidePreLoader() {
        $("#precarga").hide();
      }
});
