<?php
/**
 * Created by IntelliJ IDEA.
 * Created by Victor Muñoz.
 * Date: 30/11/2016
 * Time: 13:34
 */
?>

<div id="divformIP" class="formIP"></div>

<script type="text/javascript">
    var sform = "<form id='loginIP' target='blank' method='get' action='<?php echo $url; ?>'>";
    sform += "</form>";
    $("#divformIP").append(sform);
</script>

<button type="button" class="btn btn-primary" style="margin:0 0 10px 0;" onclick="document.getElementById('loginIP').submit();">Iplytics</button>

<script>
    // Move this card to the right side
    if (typeof moveCardToRight === "function") moveCardToRight(".layout-content-container .formIP", "unique2");
</script>