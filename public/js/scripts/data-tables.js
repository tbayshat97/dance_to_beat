/*
 * DataTables - Tables
 */


$(function () {
    // Simple Data Table

    $("#data-table-simple").DataTable({
        responsive: true,
    });

    // Simple Data Table

    $("#data-table-all-options").DataTable({
        responsive: true,
        paging: true,
        ordering: false,
        info: false,
        columnDefs: [
            {
                visible: false,
                targets: 2,
            },
        ],
        dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
        buttons: [
            {
                extend: "copy",
                className: "btn-sm btn-info",
                header: false,
                footer: true,
                exportOptions: {
                    // columns: ':visible'
                },
            },
            {
                extend: "csv",
                className: "btn-sm btn-success",
                header: false,
                footer: true,
                exportOptions: {
                    // columns: ':visible'
                },
            },
            {
                extend: "excel",
                className: "btn-sm btn-warning",
                header: false,
                footer: true,
                exportOptions: {
                    // columns: ':visible',
                },
            },
            {
                extend: "pdf",
                className: "btn-sm btn-primary",
                header: false,
                footer: true,
                exportOptions: {
                    // columns: ':visible'
                },
            },
            {
                extend: "print",
                className: "btn-sm btn-default",
                header: true,
                footer: false,
                orientation: "landscape",
                exportOptions: {
                    // columns: ':visible',
                    stripHtml: false,
                },
            },
        ],
    });

    // Row Grouping Table

    var table = $("#data-table-row-grouping").DataTable({
        responsive: true,
        columnDefs: [
            {
                visible: false,
                targets: 2,
            },
        ],
        order: [[2, "asc"]],
        displayLength: 25,
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api
                .rows({
                    page: "current",
                })
                .nodes();
            var last = null;

            api.column(2, {
                page: "current",
            })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before(
                                '<tr class="group"><td colspan="5">' +
                                    group +
                                    "</td></tr>"
                            );

                        last = group;
                    }
                });
        },
    });

    // Page Length Option Table

    $("#page-length-option").DataTable({
        responsive: true,
        columnDefs: [{ targets: "no-sort", orderable: false }],
        order: [[2, "asc"]],
        dom: "Bfrtip",
        buttons: {
            dom: {
                button: {
                    tag: "button",
                    className: "waves-effect waves-light btn mrm",
                },
            },
            // like csv Buttons,print buttons,pdfHtml5 button
            buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
    });

    // Dynmaic Scroll table

    $("#scroll-dynamic").DataTable({
        responsive: true,
        scrollY: "50vh",
        scrollCollapse: true,
        paging: false,
    });

    // Horizontal And Vertical Scroll Table

    $("#scroll-vert-hor").DataTable({
        scrollY: 200,
        scrollX: true,
    });

    // Multi Select Table

    $("#multi-select").DataTable({
        responsive: true,
        paging: true,
        ordering: false,
        info: false,
        columnDefs: [
            {
                visible: false,
                targets: 2,
            },
        ],
    });
});



// Datatable click on select issue fix
$(window).on('load', function () {
  $(".dropdown-content.select-dropdown li").on("click", function () {
    var that = this;
    setTimeout(function () {
      if ($(that).parent().parent().find('.select-dropdown').hasClass('active')) {
        // $(that).parent().removeClass('active');
        $(that).parent().parent().find('.select-dropdown').removeClass('active');
        $(that).parent().hide();
      }
    }, 100);
  });
});

var checkbox = $('#multi-select tbody tr th input')
var selectAll = $('#multi-select .select-all')

// Select A Row Function

$(document).ready(function () {
    checkbox.on("click", function () {
        $(this).parent().parent().parent().toggleClass("selected");
    });

    checkbox.on("click", function () {
        if ($(this).attr("checked")) {
            $(this).attr("checked", false);
        } else {
            $(this).attr("checked", true);
        }
    });

    // Select Every Row

    selectAll.on("click", function () {
        $(this).toggleClass("clicked");
        if (selectAll.hasClass("clicked")) {
            $("#multi-select tbody tr").addClass("selected");
        } else {
            $("#multi-select tbody tr").removeClass("selected");
        }

        if ($("#multi-select tbody tr").hasClass("selected")) {
            checkbox.prop("checked", true);
        } else {
            checkbox.prop("checked", false);
        }
    });
});
