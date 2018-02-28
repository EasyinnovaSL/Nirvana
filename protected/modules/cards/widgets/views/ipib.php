<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 24/01/2017
 * Time: 12:35
 */

use yii\helpers\Url;
?>

<div id="divformIpib" class="formIpib">
    <div class="cards">
        <div class="form-group">

            <label>
                City*
            </label>
            <div>
                <input type="text" id="cityIplib" class="form-control" name="searchText" autocomplete="off">
                <div id="autocompletecities" class="autocompletediv"></div>
            </div>

            <label>
                Distance
            </label>
            <div>
                <input type="text" id="distanceIplib" class="form-control" name="searchText">
            </div>

            <label>
                Relevant Technologies*
            </label>
            <div>
                <input type="text" id="ipcIplib" class="form-control" name="searchText" autocomplete="off">
                <div id="autocompleteipc" class="autocompletediv"></div>
            </div>

            <label class="note-div">
                *Required field
            </label>
        </div>
    </div>

    <div class="resultsIpib">
        <div id="ipibResults" class="margin-top10">
        </div>

        <div class="margin-top10">
            <button type="button" class="btn btn-primary" onclick="searchIpib();">Search</button>
        </div>
    </div>
</div>

<script>
    // Move this card to the right side
    if (typeof moveCardToRight === "function") moveCardToRight(".layout-content-container .formIpib", "unique3");

    // Autocomplete function for cities
    var prevVal = "";
    var citySlug = "";
    var ipc = "";
    var ipib_debug = true;
    $( "#cityIplib" ).keyup(function() {
        citySlug = "";
        $(this).removeClass("error");
        var txtVal = $(this).val();
        if (prevVal == txtVal) return;
        prevVal = txtVal;

        $.getJSON( "<?php echo $contentContainer->createUrl('/cards/ipib/getcities'); ?>&q="+txtVal, function( data ) {
            var s='<div class="autocomplete-suggestions">';
            $.each( data, function( key, val ) {
                s+='<div class="autocomplete-suggestion" slug="'+val.slug+'" val="'+val.name+'">'+val.name.replace(txtVal,"<strong>"+txtVal+"</strong>")+'</div>';
            });
            s+='</div>';
            $("#autocompletecities").html(s);
            $('.autocomplete-suggestion').click(function() {
                $( "#cityIplib").val($(this).attr("val"));
                citySlug = $(this).attr("slug");
                if (ipib_debug) console.log("selected city slug: "+citySlug);
                $(".autocomplete-suggestions").remove();
            });
        });

    });

    // Autocomplete function for IPC
    var prevValIpc = "";
    $( "#ipcIplib" ).keyup(function() {
        ipc = "";
        $(this).removeClass("error");
        var txtVal = $(this).val();
        if (prevValIpc == txtVal) return;
        prevValIpc = txtVal;

        $.getJSON( "<?php echo $contentContainer->createUrl('/cards/ipib/getipc'); ?>&q="+txtVal, function( data ) {
            var s='<div class="autocomplete-suggestions">';
            $.each( data, function( key, val ) {
                var txt = val.name.replace(txtVal,"<strong>"+txtVal+"</strong>");
                if (val.description != null) txt += ': '+val.description;
                s+='<div class="autocomplete-suggestion" ipckey="'+val.name+'" val="'+val.name+'">'+txt+'</div>';
            });
            s+='</div>';
            $("#autocompleteipc").html(s);
            $('.autocomplete-suggestion').click(function() {
                $("#ipcIplib").val($(this).attr("val"));
                ipc = $(this).attr("ipckey");
                if (ipib_debug) console.log("selected ipc: "+ipc);
                $(".autocomplete-suggestions").remove();
            });
        });

    });

    $(document).mouseup(function (e)
    {
        // Remove suggestion divs if the click was outside them
        var container = $("#autocompletecities").children(".autocomplete-suggestions");
        if (container && !container.is(e.target) && container.has(e.target).length === 0)
            $(container).remove();

        container = $("#autocompleteipc").children(".autocomplete-suggestions");
        if (container && !container.is(e.target) && container.has(e.target).length === 0)
            $(container).remove();
    });

    function searchIpib() {
        // Empty results list
        $("#ipibResults").children().remove();
        $("#ipibResults").append("<label>Search Results:</label>");

        // Get city slug (if not obtained automatically when clicking on a suggestion)
        if (citySlug.length == 0) {
            // If citySlug is empty, the user has not selected any suggested option
            if ($("#cityIplib").val().length > 0) {
                // If the city field has a value, get the slug of the first match of the API
                $.ajax({
                    dataType: "json",
                    url: "<?php echo $contentContainer->createUrl('/cards/ipib/getcities'); ?>&q="+$("#cityIplib").val(),
                    async: false,
                    data: null,
                    success: function( data ) {
                        $.each(data, function (key, val) {
                            citySlug = val.slug;
                            if (ipib_debug) console.log("autoselected city slug: " + citySlug);
                            return false;
                        });
                    }
                });
                if (citySlug.length == 0) {
                    // There is no match
                    if (ipib_debug) console.log("No matches");
                }
            }
        }

        // Get ipc (if not obtained automatically when clicking on a suggestion)
        if (ipc.length == 0) {
            // If empty, the user has not selected any suggested option
            if ($("#ipcIplib").val().length > 0) {
                // If the ipc field has a value, get the ipc of the first match of the API
                $.ajax({
                    dataType: "json",
                    url: "<?php echo $contentContainer->createUrl('/cards/ipib/getipc'); ?>&q="+$("#ipcIplib").val(),
                    async: false,
                    data: null,
                    success: function( data ) {
                        $.each( data, function( key, val ) {
                            ipc = val.name;
                            if (ipib_debug) console.log("autoselected ipc: "+ipc);
                            return false;
                        });
                    }
                });
                if (ipc.length == 0) {
                    // There is no match
                    if (ipib_debug) console.log("No matches");
                }
            }
        }

        // Check valid values
        if (citySlug.length == 0 || ipc.length == 0) {
            // Invalid
            if (citySlug.length == 0) $("#cityIplib").addClass("error");
            if (ipc.length == 0) $( "#ipcIplib").addClass("error");
        } else {
            // Valid -> get providers
            var url = "<?php echo $contentContainer->createUrl('/cards/ipib/getproviders'); ?>&city="
                      + citySlug + "&ipc=" + ipc;
            $.getJSON(url, function (data) {
                if (data.length == 0) {
                    // No results
                    $("#ipibResults").append("<p>No results</p>");
                } else {
                    // Create results list
                    $.each(data, function (key, val) {
                        var item = "<li><a href='" + val.ipib_url + "'>" + val.name
                                   + "</a></li>";
                        $("#ipibResults").append(item);
                    });
                }
            });
        }
    }
</script>
