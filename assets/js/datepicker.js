require("bootstrap-datepicker/js/bootstrap-datepicker");
require("bootstrap-datepicker/js/locales/bootstrap-datepicker.eu");
require("bootstrap-datepicker/js/locales/bootstrap-datepicker.es");
require("bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css");

$(document).ready(function () {

    $('.datepicker').datepicker({
        todayBtn: "linked",
        language: "eu",
        autoclose: true,
        todayHighlight: true
    })

});
