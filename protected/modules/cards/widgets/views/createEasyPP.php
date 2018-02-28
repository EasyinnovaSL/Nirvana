<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Mu�oz
 * Date: 30/11/2016
 * Time: 11:31
 */
?>

<!-- Div for the login form -->
<div id="divformeasypp"></div>
<?php
    if ($innovator == 1) {
        ?>
        <a class="btn btn-primary" id="btnEasyPP" onclick="openEasyPP();">Edit EasyPP Profile</a>
        <?php
    } else {
        if (!$link_created) {
            ?>
            <a class="btn btn-primary" id="btnEasyPP" onclick="launchEasyPP();">Create EasyPP
                Profile</a>
            <?php
        } else {
            ?>
            <a class="btn btn-primary" id="btnEasyPP" onclick="editEasyPP();">Edit and submit EasyPP
                profile</a>
            <?php
        }
    }
?>
<!-- Frame to show the destination url once loaded -->
<div id='frameeasypp' class="frameHidden"><iframe name='iframeeasypp' id='iframeeasypp' frameborder='0' width='100%' height='100%' style="z-index: 1000;"></iframe></div>

<script type="text/javascript">
    <?php if ($innovator == 1) {
     } else { ?>
    // Add the login form via jquery (->this is a workaround; it does not work simply with html, because humhub rewrites it)
    var sform = "<form id='logineasypp' target='iframeeasypp' method='post' action='<?php echo $url; ?>'>";
    sform += "<input name='userId' type='hidden' value='<?php echo $user; ?>'>";
    sform += "<input name='password' type='hidden' value='<?php echo $password; ?>'>";
    sform += "</form>";
    $("#divformeasypp").append(sform);
    <?php } ?>

    window.addEventListener('message', receiveMessage, false);

    var easypplink = "";
    var easypplinkinnovator = "";
    var epp_debug = true;
    var force = true;

    function receiveMessage(evt)
    {
        if (evt.origin === 'http://www.easypp.eu')
        {
            if (evt.data.startsWith("profileSaved")) {
                // Saved callback action
                if (epp_debug) console.log("Profile saved!");
                onSaved(<?php echo $innovator == 1 ? 1 : 0; ?>);
            } else if (evt.data.startsWith("http://")) {
                // EasyPP link callback action
                if (evt.data.indexOf("&cid=") > -1) {
                    <?php if ($innovator != 1 && !$link_created) { ?>
                    $("#frameeasypp").prepend("<a class='btn btn-primary topRightButtonX2' id='btnGetEasyPPLink' onclick='geteasypplink();'>Get EasyPP link</a>");
                    <?php } ?>
                    easypplinkinnovator = evt.data;
                    if (epp_debug) console.log("Advisor link available: " + easypplink);
                }
                else {
                    easypplink = evt.data;
                    if (epp_debug) console.log("Innovator link available: " + easypplinkinnovator);
                }
            } else {
                // Submitted callback action
                if (epp_debug) console.log("Submitted profile: "+evt.data);
                onSubmitted(evt.data, <?php echo $innovator == 1 ? 1 : 0; ?>);
            }
        }
    }

    function sendeasypplink() {
        closeeasypp();
        console.log("Advisor link encoded: " + encodeURIComponent(easypplink));
        console.log("Innovator link encoded: " + encodeURIComponent(easypplinkinnovator));
        $.ajax({
            type: "POST",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "<?php echo $contentContainer->createUrl('/cards/link/gotlink'); ?>&card_id=<?php echo $card_id; ?>&space_id=<?php echo $space->id; ?>&advisorlink="+encodeURIComponent(easypplink)+"&innovatorlink="+encodeURIComponent(easypplinkinnovator),
            async: true,
            data: null,
            success: function( data ) {
                if (epp_debug) console.log("Links added!");
                currentStream.showStream(); updateSteps();
            }
        });
    }

    function closeeasypp() {
        $("#btnCloseEasyPP").remove();
        $("#btnGetEasyPPLink").remove();
        $("#btnSubmitEasyPPLink").remove();
        var element = $("#frameeasypp").detach();
        $(element).removeClass("modalDiv2");
        $(element).addClass("hiding");
        $("#btnEasyPP").after(element);
        $("#modalDiv").remove();
    }

    function geteasypplink() {
        if (easypplink.length > 0) {
            sendeasypplink();
        } else {
            alert("You need to open a profile to select a link.");
        }
    }

    function onSaved(innovator) {
        //onSubmitted("BRSE20151105001");
        if (epp_debug) console.log("Saved!");
    }

    function onSubmitted(easyppprofile, innovator) {
        closeeasypp();
        $.ajax({
            type: "POST",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "<?php echo $contentContainer->createUrl('/cards/link/submitted'); ?>&card_id=<?php echo $card_id; ?>&space_id=<?php echo $space->id; ?>&easyppprofile="+easyppprofile,
            async: true,
            data: null,
            success: function( data ) {
                if (epp_debug) console.log("Company profile completed!");
                currentStream.showStream(); updateSteps();
            }
        });
    }

    function openModalEasyPP() {
        var element = $("#frameeasypp").detach();
        $(element).addClass("modalDiv2");
        $(element).removeClass("hiding");
        $("body").prepend(element);
        $("body").prepend("<div class='modal-backgroundX' id='modalDiv'></div>");
        window.scrollTo(0, 0);
    }

    function editEasyPP() {
        openModalEasyPP();
        force = true;
        $("#frameeasypp").prepend("<a class='btn btn-primary topRightButtonX' id='btnCloseEasyPP' onclick='closeeasypp();'>Close EasyPP</a>");
        $("#frameeasypp").prepend("<a class='btn btn-primary topRightButtonX2' id='btnSubmitEasyPPLink' onclick='onSubmitted(\"BRSE20151105001\");'>Simulate Submit</a>");
        if (epp_debug) console.log("Logging in");
        $("#logineasypp").submit();

        console.log("Link: <?php echo $url; ?>");

        // Frame onload event (once logged in go to the destination url/s)
        var iframe = document.getElementById('iframeeasypp');
        var destination2 = "<?php echo $url2; ?>";
        iframe.onload = function() {
            // Set the frame src to the destination url
            if (epp_debug) console.log("loaded easypp: " + iframe.src);
            if (force || iframe.src != destination2) {
                if (epp_debug) console.log("Going to destination");
                iframe.src = destination2;
                force = false;
            }
        }
    }

    function openEasyPP() {
        openModalEasyPP();
        $("#frameeasypp").prepend("<a class='btn btn-primary topRightButtonX' id='btnCloseEasyPP' onclick='closeeasypp();'>Close EasyPP</a>");

        // Frame onload event (once logged in go to the destination url/s)
        var iframe = document.getElementById('iframeeasypp');
        iframe.src = "<?php echo $url; ?>";
    }

    function launchEasyPP() {
        openModalEasyPP();
        force = true;
        $("#frameeasypp").prepend("<a class='btn btn-primary topRightButtonX' id='btnCloseEasyPP' onclick='closeeasypp();'>Close EasyPP</a>");
        if (epp_debug) console.log("Logging in");
        $("#logineasypp").submit();

        console.log("Link: <?php echo $url; ?>");

        // Frame onload event (once logged in go to the destination url/s)
        var iframe = document.getElementById('iframeeasypp');
        var destination2 = "<?php echo $url; ?>profile.asp?pt=<?php echo $type; ?>";
        iframe.onload = function() {
            // Set the frame src to the destination url
            if (epp_debug) console.log("loaded easypp: " + iframe.src);
            if (force || iframe.src != destination2) {
                if (epp_debug) console.log("Going to destination");
                iframe.src = destination2;
                force = false;
            }
        }
    }
</script>

