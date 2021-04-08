/**
 * Call the plugin with ajax
 *
 */
if (JSINFO) {
    jQuery('#plugin_stale')
        .show()
        .click(function (e) {
            e.preventDefault();

            // post the data
            jQuery.post(
                DOKU_BASE + 'lib/exe/ajax.php',
                {
                    call: 'plugin_stale'
                },
                // Display feedback
                // https://api.jqueryui.com/dialog/
                function (result) {
                    let dialogElement = jQuery(document.createElement('div'));
                    dialogElement.html(result.message);

                    /**
                     *
                     * @param {any | JQuery} jElement
                     */
                    let remove = function(jElement){
                        if (jElement.parent().length >0) {
                            jElement.dialog('close');
                            jElement.remove();
                            jQuery( document.activeElement ).blur();
                        }
                    }

                    dialogElement.dialog({
                        dialogClass: "stale-dialog",
                        closeOnEscape: true,
                        modal: true,
                        open: function() {
                            // close it after 2 seconds (toast)
                            setTimeout(function() {
                                remove(dialogElement)
                            }, 2000);
                        }
                    });

                    // Close it if the user click
                    jQuery(document).bind('click', function () {
                        remove(dialogElement)
                    });

                }
            );

        });
}
