<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>

<!--DataTables-->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/extensions/ColVis/js/dataTables.colVis.min.js')?>"></script>


<script type="text/javascript">


var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({
        
        
        "language": {
                "url": "<?php echo base_url('assets/plugins/datatables/lang/indonesia_lang.json')?>"
            
        }, 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('master/golongan/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        {

            "targets": [ 3 ],
            "render": function ( data, type, full, meta ) {
                return +data+ ' %';
            },
            "orderable": true,
        },
        { 
            
            "targets": [ 1 ], //first column / numbering column
            "visible": false, //set not orderable
        },
        ],
    });

    var colvis = new $.fn.dataTable.ColVis(table); //initial colvis
    $('#colvis').html(colvis.button()); //add colvis button to div with id="colvis"

});


</script>

<script type="text/javascript">

function add_golongan()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah golongan'); // Set Title to Bootstrap modal title
}

function edit_golongan(id_golongan)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('master/golongan/ajax_edit')?>/" + id_golongan,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id_golongan"]').val(data.id_golongan);
            $('[name="nama_golongan"]').val(data.nama_golongan);
            $('[name="pajak_pph21"]').val(data.pajak_pph21);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit golongan'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('master/golongan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('master/golongan/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_golongan(id_golongan)
{
    if(confirm('Anda Yakin Menghapus Data Ini?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('master/golongan/ajax_delete')?>/"+id_golongan,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}


</script>
    
<div class="box"> 
    <div class="box-header">
      <h3 class="box-title"></h3>
    </div>  
   <div class="box-body">
   <div class="row">
    
            <div class="col-md-12">
    
                <div id="colvis"></div>

                <div>
                    <button class="btn btn-primary" title="tambah data" onclick="add_golongan()">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                    <button class="btn btn-default" title="tambah data" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> Refresh
                    </button>
                </div>
            </div>
    </div>

   
       <table id="table" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="5%">NO</th>        
                    <th width="10%">ID</th> 
                    <th width="50%">JENIS GOLONGAN</th>
                    <th width="10">PAJAK</th>
                    <th width="10%">AKSI</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>NO</th>
                    <th>ID</th> 
                    <th>JENIS GOLONGAN</th>
                    <th>PAJAK</th>
                    <th>AKSI</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content col-md-10">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">golongan</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_golongan"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama golongan</label>
                            <div class="col-md-6">
                                <input name="nama_golongan" placeholder="Nama golongan . . ." class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Pajak PPH21</label>
                            <div class="col-md-6">
                                    <input name="pajak_pph21" placeholder="Persentase Pajak . . ." class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->



 <!--
<textarea name="isi" id="isi" class="form-control" style="display:none;"></textarea>
<textarea name="editor" id="editor"></textarea>

<script type="text/javascript">
function () {
var editor = CKEDITOR.replace( 'editor', {} );
editor.on( 'change', function ( ev ) {
document.getElementById( 'isi' ).innerHTML = editor.getData();
} );
})();
</script>

 -->