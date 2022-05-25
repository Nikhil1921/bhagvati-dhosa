"use strict";

var url = $("#base_url").val();
const ADMIN = $("input[name='admin']").val();
const dataTableUrl = $("input[name='dataTableUrl']").val();

const table = $('.datatables').DataTable({
    /* "pagingType": "full_numbers",
    "lengthMenu": [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        {
            extend: 'print',
            footer: true,
            exportOptions: {
                columns: ':visible'
            },
        },
        {
            extend: 'csv',
            footer: true,
            exportOptions: {
                columns: ':visible'
            },
        },
        'colvis'
    ],
    columnDefs: [ {
        targets: -1,
        visible: false
    } ], */
    "processing": true,
    "serverSide": true,
    'language': {
        'loadingRecords': '&nbsp;',
        'processing': 'Processing',
        'paginate': {
            'first': 'First',
            'next': '<i class="fa fa-arrow-circle-right"></i>',
            'previous': '<i class="fa fa-arrow-circle-left"></i>',
            'last': 'Last'
        }
    },
    "order": [],
    "ajax": {
        url: dataTableUrl,
        type: "GET",
        data: function(data) {
            data.status = $("select[name='status']").val() ? $("select[name='status']").val() : $("input[name='status']").val();
        },
        complete: function(response) {
            
        },
    },
    "columnDefs": [{
        "targets": "target",
        "orderable": false,
    }, ]
});

$("select[name='status']").change(function () {
    table.ajax.reload();
});

const script = {
    delete: function(id) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#F72B50",
            confirmButtonText: "Yes",
        }).then((willDelete) => {
            if (willDelete.value === true)
                $("#" + id).submit();
        });
        return;
    }
};