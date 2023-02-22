@extends('layout.app')
@section('titile','Data Kategori')
@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Data Kategori</h4>
    </div>


<div class="card-body">
    <div class="d-flex justify-content-end mb-4">
        <a href="#modal-form" id="tambah" class="btn btn-primary modal-tambah">Tambah Kategori</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
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
    <label for="inputAddress2">Nama Kategori</label>
    <input type="text" class="form-control" name ="nama_kategori" id="nama_kategori" placeholder="Nama Kategori">
  </div>

  <div class="form-group">
    <label for="inputAddress2">Deskripsi</label>
    <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi">
  </div>

  <div class="form-group">
    <label for="inputAddress2">Gambar</label>
    <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Gambar">
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
  

function myFunction(id) {
        const token = localStorage.getItem('token');
        confirm_dialog = confirm('yakin hapus');
          if(confirm_dialog)
          {
         
            $.ajax({
                url :'/api/kategori/'+id,
                type : 'DELETE',
                headers :
                {
                    "Authorized" : token
                },
                success : function(data)
                {
                    if(data.message == 'success')
                    {
                        alert('Berhasil dihapus');
                        location.reload();
                       // tampil_data();
                    }
                    console.log(data);
                   // tampil_data();
                }
            });
         }
      }
      
      
  function tampil_data(){
    $.ajax({
            url :'/api/kategori',
            success : function({data})
            {
                let row;
                 data.map(function(val, index)
                {
                    
                   row += `<tr>
                        <td>${index+1}</td>
                        <td>${val.nama_kategori}</td>
                        <td>${val.deskripsi}</td>
                        <td><img src="/uploads/${val.gambar}" width="150"></td>
                        <td>
                            <a id="edit" data-id="${val.id}" class="btn btn-warning edit_data">EDIT</a> 
                            <a id="hapus" href="#" onclick="myFunction(${val.id})" data-idnya="${val.id}" class="btn btn-danger btn-hapus" >HAPUS</a>
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
 
  $.get('api/kategori/'+id, function({data})
  {
    //console.log(data);
    $('input[name="nama_kategori"]').val(data.nama_kategori);
    $('input[name="deskripsi"]').val(data.deskripsi);
  }
   
  );

  
  $('.form-kategori').submit(function(e)
        {
            e.preventDefault();
          
            const token = localStorage.getItem('token');
            const frmdata = new FormData(this);
           // console.log(id);
          //alert('d');
            $.ajax({
                url :'/api/kategori/'+id,
                type : 'POST',
                data : frmdata,
                cache : false,
                contentType : false,
                processData : false,
                headers :
                {
                  'Authorization' : 'Bearer '+ token
                },
                success : function(data)
                {
                   if(!data.success)
                   {
                   // console.log(data.data);
                   alert(data.data);
                   }
                   alert(data.data);
                    //console.log(data)
                   // setCookie('token',data.token, 7);
                   // localStorage.setItem('token',data.token);
                  //  window.location.href = '/kategori';
                  tampil_data();
                },
                
            error: function(data){
                // console.log("error");
                // console.log(data);
                tampil_data();
            }
            
            });
         
        });


});

  


});


$(document).on("click","#tambah",function() {
  $('#methodkirim').remove(); //add input box
		
  $('input[name="nama_kategori"]').val('');
    $('input[name="deskripsi"]').val('');
  $('#modal-form').modal('show');
  

  $('.form-kategori').submit(function(e)
        {
            e.preventDefault();
          
            const token = localStorage.getItem('token');
            const frmdata = new FormData(this);
            console.log(token);
          //alert('d');
            $.ajax({
                url :'/api/kategori',
                type : 'POST',
                data : frmdata,
                cache : false,
                contentType : false,
                processData : false,
                headers :
                {
                  'Authorization' : 'Bearer '+ token
                },
                success : function(data)
                {
                   if(!data.success)
                   {
                    alert(data.message);
                   }
                    //console.log(data)
                   // setCookie('token',data.token, 7);
                   // localStorage.setItem('token',data.token);
                    window.location.href = '/kategori';
                    //tampil_data()
                },
                
            error: function(data){
                console.log("error");
                console.log(data);
                tampil_data();
            }
            });
         
        });

  //const id = $(this).data('id');
 
});

    $(function()
    {





       
       
     
    });
     
   
    
       
</script>
@endpush