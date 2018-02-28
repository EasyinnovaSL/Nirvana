<iframe id="iframepage" style="width:100%; height: 1400px; overflow:hidden;" scrolling="no" seamless="seamless" src="<?php echo $manageUrl; ?>">
<?php echo humhub\widgets\LoaderWidget::widget(); ?>
</iframe>

<style>
    #iframepage {
        border: none;
    }
</style>

<script>
    window.onload = function (evt) {
        //setSize();
    }
    window.onresize = function (evt) {
        //setSize();
    }

    function setSize() {

        //$('#iframepage').css('height', window.innerHeight - 170 + 'px');
        //$('#iframepage').css('height', window.innerHeight + 170 + 'px');
    }

    $('#iframepage').load(function () {
        $('html, body').scrollTop(0);
    });



</script>
