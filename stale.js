/**
 * Add a click handler to the
 * element with the `plugin_stale` class
 */

(function IIFE(){
    const queryParameterKey = "stale";
    jQuery('.plugin_stale')
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
                    const actualUrl = new URL(window.location.href);
                    actualUrl.searchParams.set(queryParameterKey,result.message);
                    window.location.assign(actualUrl.toString());
                }
            );
        });
    jQuery(function(){

        const actualUrl = new URL(window.location.href);
        if(actualUrl.searchParams.has(queryParameterKey)){

            const sec = 10;
            const message = actualUrl.searchParams.get(queryParameterKey);
            let dialogElement = jQuery(document.createElement('div'));
            dialogElement.html(`<h3>Stale</h3><p>${message}</p><p>The page was reloaded.</p><p>Note: This window will close automatically after ${sec} second if you don't click or press any key.</p>`);

            /**
             *
             * @param {any | JQuery} jElement
             */
            let remove = function (jElement) {
                if (jElement.parent().length > 0) {
                    jElement.dialog('close');
                    jElement.remove();
                    jQuery(document.activeElement).blur();
                }
            };

            dialogElement.dialog({
                dialogClass: "stale-dialog",
                closeOnEscape: true,
                modal: true,
                open: function () {
                    // close it after 2 seconds (toast)
                    setTimeout(function () {
                        remove(dialogElement)
                    }, sec*1000);
                }
            });

            // Close it if the user click or press any key
            jQuery(document).on("click", function () {
                remove(dialogElement)
            });
            jQuery(document).on("keypress", function () {
                remove(dialogElement)
            });

        }
    })
})();


