
$(document).ready(function () {

    $('.btnFormEmployeeZerrendaType').on('click', function () {
        $('#form_employee_zerrenda_type').submit();
    });

    $('btnFormEmployeeZerrendaTypeList').on('click', function () {
        $('#form_employee_zerrenda_type').submit();
    });

    $('.btnZerrendaType').on('click', function () {
        const employeeid = $(this).data('employeeid');
        const zerrendaid = $(this).data('zerrendaid');
        const url = Routing.generate('employee_zerrenda_type_new', {'employeeid': employeeid, 'zerrendaid': zerrendaid});
        console.log(url);
        $('.modalChangeTypeListContent').load(url, function (data) {



            if (CKEDITOR.instances["employee_zerrenda_type_notes"]) { CKEDITOR.instances["employee_zerrenda_type_notes"].destroy(true); delete CKEDITOR.instances["employee_zerrenda_type_notes"]; }





            CKEDITOR.replace("employee_zerrenda_type_notes", {"toolbar":[["Bold","Italic"],["NumberedList","BulletedList","-","Outdent","Indent"],["Link","Unlink"],["About"]],"uiColor":"#ffffff","language":"eu"});



        });
        $('#modalChangeTypeList').modal()
    });
});
