<?php
/**
* 
*/

defined('ABSPATH') or die(-1);

?>
<div id="cjt-dead-notice" class="notice">
    <h1>IMPORTANT NOTE</h1>
    <p>The CSS & JavaScript Toolbox plugin on WordPress.org is no longer supported. This has been replaced by our new code management plugin called Easy Code Manager, which you can download for free here: <a href="https://wordpress.org/plugins/easy-code-manager" target="_blank">Easy Code Manager on WordPress.org</a></p>
    <p>This free version has been fully redesigned and does not have a number of features you would expect in CSS & JavaScript Toolbox. That said, you may wish to stay on CSS & JavaScript Toolbox unless you intend to update to our premium plugin called: <a href="https://easy-code-manager.com" target="_blank">Easy Code Manager PLUS</a>.</p>
    
    <br>
    <a style="float: right;" href="#">Dismiss</a>
    <br>
    &nbsp;
</div>

<script type="text/javascript">

    /**
    * 
    */
    (function($)
    {
    
        $('#cjt-dead-notice > a').click(
            
            function()
            {
                
                if (!confirm('By clicking dismiss you force this message to don\'t display again. Are your sure?'))
                {
                    return false;
                }
                
                $.post(ajaxurl, 
                    {
                        action : 'cjt-dead-notice'
                    }
                ).done(
                    
                    function()
                    {
                        $('#cjt-dead-notice').hide();
                    }
                );
                
                return false;
            }
        
        );
          
    })(jQuery);
</script>