const $ = require('jquery');
global.$ = global.jQuery = $;

import moment from "moment";
window.moment = moment;

import Swal from "sweetalert2";

require('bootstrap');
require('datatables.net-bs4');
import "datatables.net-bs4/css/dataTables.bootstrap4.min.css";
import "typeahead.js";

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

require('select2');

$(document).ready(function () {

    $('[data-toggle="popover"]').popover();

    $('.myselect2').select2();

    $('.myalert').each(function (index) {
        const myicon = $(this).data('alert');
        const msg = $(this).data('message');
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: myicon,
            title: msg,
        })
    });

    const appLocale = $('#app_locale').val();
    const datatablesLocaleURL = "/build/libs/datatables/locales/" + appLocale + ".json";

    $('.mydatatable').DataTable({
        language: {
            url: datatablesLocaleURL
        },
        "paging": true,
        "ordering": true,
        "info": true,
        "bLengthChange": true,
        "order": []
    });


    $('body').on('click', '.btnRemoveRow', function () {
        const that = $(this);
        Swal.fire({
            title: 'Ziur zaude?',
            text: "Ezin izango duzu berreskuratu onartuz gero.",
            type: 'warning',
            animation: false,
            customClass: {
                popup: 'animated tada'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Bai, ezabatu!'
        }).then((result) => {
            if (result.value) {
                console.log(result.value);
                $(that).closest('form').submit();
            }
        });
    });

    $('.btnFormAddEmployeeFromFileSubmit').on('click', function () {
        $('#form_add_employee_from_file').submit();
    });
    $('.btnFormAddEmployeeFromZerrendaSubmit').on('click', function () {
        $('#form_add_employee_from_zerrenda').submit();
    });


    $('.custom-file-input').on('change', function () {
        const fileName = $(this).val();
        $(this).next('.form-control-file').addClass("selected").html(fileName);
    });

    // Employee
    $(".btnZerrendaType").on("click", function () {
        const employeeid = $(this).data("employeeid");
        const zerrendaid = $(this).data("zerrendaid");
        const typeid = $(this).data("typeid");

        $("#employee_zerrenda_type_zerrenda").val(zerrendaid).trigger('change');
        $("#employee_zerrenda_type_type").val(typeid).trigger('change');

        $("#modalChangeType").modal('show');
    });

    $("#employee_zerrenda_type_zerrenda").on("select2:select", function (e) {

        const employeeid = $("#employee_zerrenda_type_employee").val();

        console.log("employeeid: " + employeeid + " zerrendaid: " + e.params.data.id);

        const url = Routing.generate("get_employeezerrenda_position_employee", {
            employeeid: employeeid,
            zerrendaid: e.params.data.id
        });
        $.ajax({
            url: url,
            success: function ( response ) {
                $("#employee_zerrenda_type_lastPosition").val(response.position);

            }
        });

        const url2 = Routing.generate('get_employeezerrendatype', {'employeeid': employeeid, 'zerrendaid': e.params.data.id})
        $.ajax({
            url: url2,
            success: function ( response ) {
                console.log("SUCCESS 2")
                console.log(response);

            }
        });

    });

    // Employee select
    $('.mySelect').on('change', function () {
        const miid = $(this).val();
        if(this.checked) {
            $('#employee_select_select_' + miid).prop('checked',true);
        } else {
            $('#employee_select_select_' + miid).prop('checked',false);
        }
    });

    $('.mySelect:checkbox:checked').each(function () {
        console.log($(this).val());
        const miid = $(this).val();
        $('#employee_select_select_' + miid).prop('checked',true);
    });

    $('.btnFormAddEmployeeSelectFormSubmit').on('click', function () {
        $('#formAddEmployeeSelectForm').submit();
    });


    // JOB NEW
    // $('#job_arrazoia').on('change', function () {
     $('#job_arrazoia').on('select2:select', function (e) {
         const data = e.params.data;
         console.log('params');
         console.log(e.params.data.id);
        const url = Routing.generate("get_arrazoia", {'id': e.params.data.id});
        console.log(url);
        $.ajax({
            url: url,
            success: function (data) {
                console.log('success');
                console.log(data);
                if ( data.aldibaterako ) {
                    $('#divPrograma').show()
                } else {
                    $('#divPrograma').hide()
                }
            }
        })
    })

    $("#erantzuna_color").on("change", function () {
        console.log(this.value);
        // remove all clases
        $('#divAdibide').removeClass().addClass("card").addClass(this.value);

    });
});


