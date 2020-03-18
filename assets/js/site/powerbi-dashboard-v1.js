"use strict";

// Class Definition
var PowerbiDashboard = function() {

    // Public Functions
    return {
        init: function() {
            $('.btn-actions').removeClass('d-none');
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    PowerbiDashboard.init();
});
