<?php ?>

<div class="btn-group">
    <a href="#" id="icon-interactive-tutorial" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-info"></i></a>
</div>

<script type="text/javascript">
    $('#icon-interactive-tutorial').click(function () {
        if(enjoyhint_script_steps != null){
            enjoyhint_instance = new EnjoyHint({});
            enjoyhint_instance.set(enjoyhint_script_steps);
            enjoyhint_instance.run();
        }
    })
</script>