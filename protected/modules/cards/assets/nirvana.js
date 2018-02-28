function showCardBody(obj,id){
  var cbody = $('.card-body.'+id);
if(cbody.is(':visible')) {
    cbody.slideUp(function(){ obj.blur().find('i').removeClass('fa-angle-up').addClass('fa-angle-down');});
}else {
    cbody.slideDown(function(){obj.blur().find('i').removeClass('fa-angle-down').addClass('fa-angle-up');});

        }


}

function updateSteps () {
    jQuery.get(showsteps, function (html) {
        $('#step_container').html(html);
    });
    //location.reload();
}

function moveCardToRight(card, sclass) {
    // Moves a card from the main wall to the right side
    if ( $(card).length ){
        var element = $(card).closest(".wall-entry").detach();
        $(element).addClass(sclass);
        $(element).find(".pull-right").remove();
        $(element).find(".card-body").css({ "display":"block" });
        $("." + sclass).remove();
        $('.panel-activities').parent().append(element);
    }
}