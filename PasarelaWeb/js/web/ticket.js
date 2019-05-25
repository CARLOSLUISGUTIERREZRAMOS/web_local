$(function () {
    
      $("body").on("click", ".btn_ver_ticket", function () {
          
          number_ticket = $(this).attr('id');
          
          $.ajax({
            type: "POST",
            url: '/PasarelaWeb/TicketStarPeru/MostrarTicket',
            data: 'number_ticket=' + number_ticket,
            success: function (data)
            {
               $('#areaImprimir').html(data);
               $('#etktModal').modal('show');
            }
        });
          
          
      });
    
});