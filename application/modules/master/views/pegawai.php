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
            "url": "<?php echo site_url('master/pegawai/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ 1, 4, 6, 9 ], //first column / numbering column
            "visible": false, //set not visible
        },
        ],

    });

    var colvis = new $.fn.dataTable.ColVis(table); //initial colvis
    $('#colvis').html(colvis.button()); //add colvis button to div with id="colvis"

     $('.datepicker').datepicker();


    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });


});

function add_pegawai()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah pegawai'); // Set Title to Bootstrap modal title
}

function edit_pegawai(id_pegawai)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('master/pegawai/ajax_edit')?>/" + id_pegawai,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id_pegawai"]').val(data.id_pegawai);
            $('[name="nip"]').val(data.nip);
            $('[name="nama_pegawai"]').val(data.nama_pegawai);
            $('[name="tgl_lahir"]').val(data.tgl_lahir);
            $('[name="npwp"]').val(data.npwp);
            $('[name="alamat_pegawai"]').val(data.alamat_pegawai);
            $('[name="id_jabatan"]').val(data.id_jabatan);
            $('[name="id_golongan"]').val(data.id_golongan);
            $('[name="id_sekolah"]').val(data.id_sekolah);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit pegawai'); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('master/pegawai/ajax_add')?>";
    } else {
        url = "<?php echo site_url('master/pegawai/ajax_update')?>";
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

function delete_pegawai(id_pegawai)
{
    if(confirm('Anda Yakin Menghapus Data Ini?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('master/pegawai/ajax_delete')?>/"+id_pegawai,
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
                    <button class="btn btn-primary" title="tambah data" onclick="add_pegawai()">
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
                    <th width="">NO</th>
                    <th width="">ID</th>
                    <th width="">NIP</th>
                    <th width="">NAMA PEGAWAI</th>
                    <th width="">TANGGAL LAHIR</th>
                    <th width="">NPWP</th>
                    <th width="">ALAMAT</th>
                    <th width="">JABATAN</th>
                    <th width="">GOLONGAN</th>
                    <th width="">SEKOLAH</th>
                    <th width="10%">AKSI</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th width="">NO</th>
                    <th width="">ID</th>
                    <th width="">NIP</th>
                    <th width="">NAMA PEGAWAI</th>
                    <th width="">TANGGAL LAHIR</th>
                    <th width="">NPWP</th>
                    <th width="">ALAMAT</th>
                    <th width="">JABATAN</th>
                    <th width="">GOLONGAN</th>
                    <th width="">SEKOLAH</th>
                    <th width="">AKSI</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">pegawai</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_pegawai"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">NIP</label>
                            <div class="col-md-9">
                                <input name="nip" placeholder="Nomor Induk Pegawai . . ." class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">pegawai</label>
                            <div class="col-md-9">
                                <input name="nama_pegawai" placeholder="Nama pegawai . . ." class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group date">
                            <label class="control-label col-md-3">Tanggal Lahir</label>
                            <div class="col-md-4">
                                <input name="tgl_lahir" class="form-control" type="text" data-provide="datepicker">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">    
                            <label class="control-label col-md-3">NPWP</label>
                            <div class="col-md-9">
                                <input name="npwp" placeholder="Nomor Pokok Wajib Pajak . . ." class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9">
                                <textarea name="alamat_pegawai" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-3">Jabatan</label>
                            <div class="col-md-6">
                            <select name="id_jabatan" class="form-control">
                                  <?php 
                                  foreach ($jabatan as $jabatan) { 
                                    echo "<option value='$jabatan->id_jabatan'>$jabatan->nama_jabatan</option>"; }?>
                            </select>
                            <span class="help-block"></span>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-md-3">Golongan</label>
                            <div class="col-md-6">
                            <select name="id_golongan" class="form-control">
                                  <?php 
                                  foreach ($golongan as $golongan) { 
                                    echo "<option value='$golongan->id_golongan'>$golongan->nama_golongan</option>"; }?>
                            </select> 
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jabatan</label>
                            <div class="col-md-6">
                            <select name="id_sekolah" class="form-control">
                                  <?php 
                                  foreach ($sekolah as $sekolah) { 
                                    echo "<option value='$sekolah->id_sekolah'>$sekolah->nm_sekolah</option>"; }?>
                            </select> 
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