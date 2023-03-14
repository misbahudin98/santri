
if (tambah) {

    var tableX = $("#example")
        .DataTable({
            "data": this.data,
            "columns": this.column,
            lengthChange: false,
            scrollX: true,
            buttons: [{
                text: "Tambah",
                className: " btn btn-primary btn-sm  btn-flat",
                action: function (e, dt, node, config) {
                    $('#tambah').modal('show');
                },
            }],
        }).buttons().container()
        .appendTo("#example_wrapper .col-md-6:eq(0)");

} else {
    var tableX = $("#example")
        .DataTable({
            "data": this.data,
            "columns": this.column,
            lengthChange: false,
            scrollX: true,

        })

}

$('.btn-warning').click(function () {


     id = $(this).data('id');
    $.ajax({
        type: "post",
        url: domain + subdomain + edit,
        data: { id: id },
        success: function (data) {
            $("#edit").modal("show")
            $('#edit-form').html(data);
                $('.selectpicker').selectpicker('refresh')

       
        }
    });

});

$('.btn-info').click(function () {
    let id = $(this).data('id');
    $.ajax({
        type: "post",
        url: domain + subdomain + edit_proses,
        data: { id: id },
        success: function (data) {
         
            $("#proses").modal("show")
            $('#proses-form').html(data);
                $('.selectpicker').selectpicker('refresh')

        }
    });
});

$('.extras').click(function () {
    // $("select option[selected]").removeAttr("selected");
    // $("input").removeAttr("value");
    // $("textarea").removeAttr("value");

    let id = $(this).data('id');
    let status = $(this).data('status');
    $.ajax({
        type: "post",
        url: domain + subdomain + "/edit_extras",
        data: { id: id, status: status },
        success: function (data) {
            $("#extras").modal("show")
            $('#extras-form').html(data);
         

            if (status != "sudah") {
                $("#ex").attr("action", domain + subdomain + "update_" + status)
                $("#ex").attr("method", "POST")

            }
                $('.selectpicker').selectpicker('refresh')

        }
    });

});


$('.btn-danger').click(function () {

    let id = $(this).data('id');

    if (confirm("apakah anda Ingin menghapus data ini ?") === true) {
        window.location.href = domain + subdomain + delete_data + "/" + id;
    }

});
$(document).on('change', '[name="provinsi"]', function (e) {
    $('[name="kabupaten"]').val('');
    $('[name="kabupaten"]').trigger('change');

    $('[name="kecamatan"]').val('');
    $('[name="kecamatan"]').trigger('change');

    $('[name="desa"]').val('');
    $('[name="desa"]').trigger('change');

    val = $(this).val()
    // console.log(val);
    $.post(domain + "alamat/kabupaten", { id: val },
        function (data) {
            // console.log(data);
            $('[name="kabupaten"]').html(data)
                $('.selectpicker').selectpicker('refresh')

        },
    );

});

$(document).on('change', '[name="kabupaten"]', function (e) {

    $('[name="kecamatan"]').val('');
    $('[name="kecamatan"]').trigger('change');

    $('[name="desa"]').val('');
    $('[name="desa"]').trigger('change');

    val = $(this).val()
    // console.log(val);
    $.post(domain + "alamat/kecamatan", { id: val },
        function (data) {
            // console.log(data);
            $('[name="kecamatan"]').html(data)
                $('.selectpicker').selectpicker('refresh')

        },
    );

});



$(document).on('change', '[name="kecamatan"]', function (e) {
    $('[name="desa"]').val('');
    $('[name="desa"]').trigger('change');

    val = $(this).val()
    // console.log(val);
    $.post(domain + "alamat/kelurahan", { id: val },
        function (data) {
            // console.log(data);
            $('[name="desa"]').html(data)
                $('.selectpicker').selectpicker('refresh')

        },
    );
});

$(document).ready(function() {
    if (last) {
        $("."+last).addClass(" active")
        $(".menu-"+first).addClass(" menu-open")
        $(".menu1-"+first).addClass(" active")
    }
});