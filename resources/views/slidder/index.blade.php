@extends('layout.app')
@section('titile','Data Kategori')
@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Data Slidder</h4>
    </div>


<div class="card-body">
    <div class="d-flex justify-content-end mb-4">
        <a href="#modal-form" id="tambah" class="btn btn-primary modal-tambah">Tambah Slidder</a>
    </div>

    <div class="auto-load text-center">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <path fill="#000"
                    d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                    <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                        from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                </path>
            </svg>
  </div>


    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                 </thead>
            <tbody id="tampil_data"></tbody>
        </table>
    </div>

</div>
</div>
<!-- <div class="alert alert-danger">
        <ul>
             @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
             @endforeach
        </ul>
    </div> -->

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
    <label for="inputAddress2">Nama Slidder

</label>
    <input type="text" class="form-control" name ="nama_slidder" id="nama_slidder" placeholder="Nama Slidder">
    <span class="text-danger error-text nama_slidder_error"></span>
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

$(document).ready(function()
{
  tampil_data();
  $("#tampil_data").on("click",".hapus", function() {
    const id = $(this).data('id');
    const token = localStorage.getItem('token');
    confirm_dialog = confirm('yakin hapus');
    if(confirm_dialog)
    {
      $.ajax({
        url :'/api/slidder/'+id,
        type : 'DELETE',
        headers :{
          "Authorized" : token
        },
        success : function(data){
          if(data.message == 'succes')
            {
              alert('Berhasil dihapus');location.reload();
            }
        }
      });
    }
  });
      
      
  function tampil_data(){
    $.ajax({
      url :'/api/slidder',
      beforeSend : function()
      {
        $('.auto-load').show();
      },
      success : function({data})
      {
        if(data.length == 0)
              {
                $('.auto-load').hide();
                $('tbody').append(`<p class="fw-bolder">Tidak ada data</p>`);
              }
              else
              {      
        let row;
        data.map(function(val, index)
        {
          row += `<tr>
                  <td>${index+1}</td>
                  <td>${val.nama_slidder}</td>
                  <td>${val.deskripsi}</td>
                  <td><img src="/uploads/${val.gambar}" width="150"></td>
                  <td>
                    <a id="edit" data-id="${val.id}" class="btn btn-warning edit_data">EDIT</a> 
                    <a id="hapus"  data-id="${val.id}" class="btn btn-danger hapus" >HAPUS</a>
                  </td></tr>`;
        });
        $('.auto-load').hide();
        $('thead').append(`<tr><th>No</th><th>Nama Slidder</th><th>Deskripsi</th><th>Gambar</th><TH>Aksi</th></tr>`);
        $('tbody').append(row);
      }}
    });
  }


  $("#tampil_data").on("click",".edit_data", function() 
  {
    $(document).find('span.error-text').text('');
    $('#methodkirim').remove();
    $('#modal-form').modal('show');
    $('#methodnya').append('<input type="hidden" id="methodkirim" name="_method" value="PUT">'); //add input box
    const id = $(this).data('id');
    $.get('/api/slidder/'+id, function({data})
    {
      //console.log(data);
      $('input[name="nama_slidder"]').val(data.nama_slidder);
      $('input[name="deskripsi"]').val(data.deskripsi);
     
    });

    $('.form-kategori').submit(function(e)
    {
      e.preventDefault();
      const token = localStorage.getItem('token');
      const frmdata = new FormData(this);
      $.ajax({
        url :'/api/slidder/'+id,
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
             // alert('kosong');
            }
            else
            {
              alert(data.msg);
              window.location.href = '/admin/slidder';
            }
        }
      });
    });
  });

  
  $("#tambah").on("click", function() 
  {
    $('#methodkirim').remove(); //add input box
    $('input[name="nama_slidder"]').val('');
    $('input[name="deskripsi"]').val('');
    $('#modal-form').modal('show');
    $('.form-kategori').submit(function(e)
    {
      e.preventDefault();
        const token = localStorage.getItem('token');
        const frmdata = new FormData(this);
        $.ajax({
          url :'/api/slidder',
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
             // alert('kosong');
            }
            else
            {
              alert(data.msg);
              window.location.href = '/admin/slidder';
            }
           // console.log(data)
           // alert('Data berhasil disimpan');
           // window.location.href = '/slidder';
          }
          // ,
          // error: function(data){
          //   alert('Data gagal disimpan');
          //   window.location.href = '/slidder';
          // }
        });
    });
  });
});

  
</script>
@endpush
