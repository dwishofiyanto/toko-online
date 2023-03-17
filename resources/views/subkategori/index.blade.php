@extends('layout.app')
@section('titile','Data Kategori')
@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Data Subkategori</h4>
    </div>


<div class="card-body">
    <div class="d-flex justify-content-end mb-4">
        <a href="#modal-form" id="tambah" class="btn btn-primary modal-tambah">Tambah Subkategori</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Subkategori</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <TH>Aksi</th>
                </tr>
            </thead>
            <tbody id="tampil_data"></tbody>
        </table>
    </div>

</div>
</div>
<div class="alert alert-danger">
        <ul>
             @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
             @endforeach
        </ul>
    </div>

<div class="modal" id="modal-form" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="form-kategori" method="post" action="#">
     
      <div id="methodnya"><div id="divmethodnya"></div></div>
  
  <div class="form-group">
    <label for="inputAddress2">Nama Subkategori

</label>
    <input type="text" class="form-control" name ="nama_subkategori" id="nama_subkategori" placeholder="Nama Subkategori">
    <span class="text-danger error-text nama_subkategori_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Kategori</label>
  <select name="id_kategori" id="id_kategori"  class="form-control" >
  <option>Pilih Kategori</option>
</select>
<span class="text-danger error-text id_kategori_error"></span>
    <!--<input type="text" class="form-control" name ="id_kategori" id="id_kategori" placeholder="id kategori">-->
  </div>


  <div class="form-group">
    <label for="inputAddress2">Deskripsi</label>
    <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi">
    <span class="text-danger error-text deskripsi_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Gambar</label>
    <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar">
    <span class="text-danger error-text gambar_error"></span>
  </div>
 
  <button type="submit" class="btn btn-primary">SIMPAN</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>


@endsection
@push('js')
<script>
    function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

$(document).ready(function(){
  tampil_data();
  jQuery.ajax({
                    url:'/api/kategori/',
                    type:'GET',
                    dataType:"json",
                    success:function({data})
                    {
                       
                        $('select[name="id_kategori"]').empty();

                        data.map(function(val, index){
                       // console.log('dd');
                    //   $.each(data, function(id, nama_kategori){
                            $('select[name="id_kategori"]').append('<option value="'+val.id+'">'+val.nama_kategori+'</option>');
                        });
                    },
                });
  $("#tampil_data").on("click",".hapus", function() {
    const id = $(this).data('id');
   // alert('ss');
//function myFunction(id) {
        const token = localStorage.getItem('token');
        confirm_dialog = confirm('yakin hapus');
          if(confirm_dialog)
          {
         
            $.ajax({
                url :'/api/subkategori/'+id,
                type : 'DELETE',
                headers :
                {
                    "Authorized" : token
                },
                success : function(data)
                {
                    if(data.message == 'succes')
                    {
                        alert('Berhasil dihapus');
                        location.reload();
                       //tampil_data();
                    }
                    console.log(data);
                   // tampil_data();
                }
            });
         }
      });
      
      
  function tampil_data(){
    $.ajax({
            url :'/api/subkategori',
            success : function({data})
            {
                let row;
                 data.map(function(val, index)
                {
                    
                   row += `<tr>
                        <td>${index+1}</td>
                        <td>${val.nama_subkategori}</td>
                        <td>${val.categories.nama_kategori}</td>
                        <td>${val.deskripsi}</td>
                        <td><img src="/uploads/${val.gambar}" width="150"></td>
                        <td>
                            <a id="edit" data-id="${val.id}" class="btn btn-warning edit_data">EDIT</a> 
                            <a id="hapus"  data-id="${val.id}" class="btn btn-danger hapus" >HAPUS</a>
                        </td></tr>`;
                });
                $('tbody').append(row);
            }
        });

  }
//$('#edit').on('click',function(){
  $("#tampil_data").on("click",".edit_data", function() {
    //tampil_data();
  $('#methodkirim').remove();
  $('#modal-form').modal('show');
  $('#methodnya').append('<input type="hidden" id="methodkirim" name="_method" value="PUT">'); //add input box
  
  const id = $(this).data('id');
 
  $.get('/api/subkategori/'+id, function({data})
  {
    //console.log(data);
    $('input[name="nama_subkategori"]').val(data.nama_subkategori);
    $('input[name="id_kategori"]').val(data.id_kategori);
    $('input[name="deskripsi"]').val(data.deskripsi);
    $('select[name="id_kategori"]').val(data.id_kategori);
  }
   
  );

  
  $('.form-kategori').submit(function(e)
        {
            e.preventDefault();
          
            const token = localStorage.getItem('token');
            const frmdata = new FormData(this);
             $.ajax({
                url :'/api/subkategori/'+id,
                type : 'POST',
                data : frmdata,
                cache : false,
                contentType : false,
                processData : false,
                headers :
                {
                  'Authorization' : 'Bearer '+ token
                },
                beforeSend: function()
          {
            $(document).find('span.error-text').text('');
          },
          success : function(data)
          {
            if(data.status == 0)
            {
              $.each(data.error, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
         
            }
            else
            {
              alert(data.msg);
              window.location.href = '/admin/subkategori';
            }
          }
            
            });
         
        });


});

  


});


$(document).on("click","#tambah",function() {
  $('#methodkirim').remove(); //add input box
		
  $('input[name="nama_subkategori"]').val('');
    $('input[name="deskripsi"]').val('');
  $('#modal-form').modal('show');
  

  $('.form-kategori').submit(function(e)
        {
            e.preventDefault();
          
            const token = localStorage.getItem('token');
            const frmdata = new FormData(this);
            $.ajax({
                url :'/api/subkategori',
                type : 'POST',
                data : frmdata,
                cache : false,
                contentType : false,
                processData : false,
                headers :
                {
                  'Authorization' : 'Bearer '+ token
                },
                beforeSend: function()
          {
            $(document).find('span.error-text').text('');
          },
          success : function(data)
          {
            if(data.status == 0)
            {
              $.each(data.error, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
         
            }
            else
            {
              alert(data.msg);
              window.location.href = '/admin/subkategori';
            }
          }
            });
         
        });

});      
</script>
@endpush