@extends('layout.app')
@section('titile','Data Pelanggan')
@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Data Pelanggan</h4>
    </div>


<div class="card-body">
<div id="loading" class="d-flex justify-content-center">
<button class="btn btn-primary" type="button" disabled>
  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  <span class="visually-hidden">Loading...</span>
</button>
</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                 
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
    <span class="text-danger error-text nama_kategori_error"></span>
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
  





      $("#tampil_data").on("click",".hapus", function() {
    const id = $(this).data('id');
    const token = localStorage.getItem('token');
    confirm_dialog = confirm('yakin hapus');
    if(confirm_dialog)
    {
      $.ajax({
        url :'/api/kategori/'+id,
        type : 'DELETE',
        headers :{
          "Authorized" : token
        },
        success : function(data){
          //console.log(data.msg)
         alert(data.msg);
             window.location.href = '/admin/kategori';
        }
      });
    }
  });
      
      
  function tampil_data(){
    const token = localStorage.getItem('token');
   
    $.ajax({
            url :'/api/pelanggan',
            headers :
                {
                  'Authorization' : 'Bearer '+ token
                },
                beforeSend: function()
          {
            $('tbody').append('<tr><td>load</td></tr>');
            
          },
            success : function({data})
            {
                let row;
                 data.map(function(val, index)
                {
                    
                   row += `<tr>
                        <td>${index+1}</td>
                        <td>${val.nama_pelanggan}</td>
                        <td>${val.no_hp}</td>
                        <td>${val.alamat_lengkap}</td>
                       </tr>`;
                });
                $('tbody').append(row);
            }
        });

  }


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
              window.location.href = '/admin/kategori';
            }
          }
          });
         
        });


});
    
   
    
       
</script>
@endpush