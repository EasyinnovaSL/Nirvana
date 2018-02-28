<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 30/11/2016
 * Time: 12:03
 */
?>

<input type="text" id="searchText" class="form-control inputSearch1" name="searchText">
<button type="button" class="btn btn-primary" onclick="window.open('<?php echo $url; ?>'+document.getElementById('searchText').value.replace(' ','+'));">Search</button>
<script>
    // Move this card to the right side
    if (typeof moveCardToRight === "function") moveCardToRight(".layout-content-container .inputSearch1", "unique1");
</script>