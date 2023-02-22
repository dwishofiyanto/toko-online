@extends('layout.app')
@section('titile','Data Kategori')
@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Data Produk</h4>
    </div>


<div class="card-body">
    <div class="d-flex justify-content-end mb-4">
        <a href="#modal-form" id="tambah" class="btn btn-primary modal-tambah">Tambah Produk</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr><th>No</th><th>Kategori</th><th>Subkategori</th><th>Nama Barang</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Bahan</th>
                <th>SKU</th>
                <th>Ukuran</th>
                <th>Warna</th>
                <th>Gambar</th>
                <TH>Aksi</th></tr>
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
    <label for="inputAddress2">Nama Kategori</label>
    <input type="text" class="form-control" name ="id_kategori" id="id_kategori" placeholder="Nama Kategori">
    <span class="text-danger error-text id_kategori_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Nama Subkategori</label>
    <input type="text" class="form-control" name ="id_subkategori" id="id_subkategori" placeholder="Nama Subkategori">
    <span class="text-danger error-text id_subkategori_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Nama Barang</label>
    <input type="text" class="form-control" name ="nama_barang" id="nama_barang" placeholder="Nama Barang">
    <span class="text-danger error-text nama_barang_error"></span>
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
 
  <div class="form-group">
    <label for="inputAddress2">Harga</label>
    <input type="text" class="form-control" name ="harga" id="harga" placeholder="Harga">
    <span class="text-danger error-text harga_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Diskon</label>
    <input type="text" class="form-control" name ="diskon" id="diskon" placeholder="Nama Diskon">
    <span class="text-danger error-text diskon_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Bahan</label>
    <input type="text" class="form-control" name ="bahan" id="bahan" placeholder="Nama Bahan">
    <span class="text-danger error-text bahan_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Nama Tags</label>
    <input type="text" class="form-control" name ="tags" id="tags" placeholder="Nama Tags">
    <span class="text-danger error-text tags_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Nama SKU</label>
    <input type="text" class="form-control" name ="sku" id="sku" placeholder="Nama SKU">
    <span class="text-danger error-text sku_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Ukuran</label>
    <input type="text" class="form-control" name ="ukuran" id="ukuran" placeholder="Ukuran">
    <span class="text-danger error-text ukuran_error"></span>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Warna</label>
    <input type="text" class="form-control" name ="warna" id="warna" placeholder="Warna">
    <span class="text-danger error-text warna_error"></span>
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
        url :'/api/produk/'+id,
        type : 'DELETE',
        headers :{
          "Authorized" : token
        },
        success : function(data){
          //console.log(data.msg)
         alert(data.msg);
             window.location.href = '/produk';
        }
      });
    }
  });
      
      
  function tampil_data(){
    $.ajax({
      url :'/api/produk',
      success : function({data})
      {
        let row;
        data.map(function(val, index)
        {
          row += `<tr>
                  <td>${index+1}</td>
                  <td>${val.categories.nama_kategori}</td>
                  <td>${val.subcategories.nama_subkategori}</td>
                  <td>${val.nama_barang}</td>
                  <td>${val.harga}</td>
                  <td>${val.diskon}</td>
                  <td>${val.bahan}</td>
                  <td>${val.sku}</td>
                  <td>${val.ukuran}</td>
                  <td>${val.warna}</td>
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


  $("#tampil_data").on("click",".edit_data", function() 
  {
    $('#methodkirim').remove();
    $('#modal-form').modal('show');
    $('#methodnya').append('<input type="text" id="methodkirim" name="_method" value="PUT">'); //add input box
    const id = $(this).data('id');
    $.get('api/produk/'+id, function({data})
    {
      alert(data.ukuran)
      $('input[name="id_kategori"]').val(data.id_kategori);
      $('input[name="id_subkategori"]').val(data.id_subkategori);
      $('input[name="nama_barang"]').val(data.nama_barang);
      $('input[name="deskripsi"]').val(data.deskripsi);
     // $('input[name="gambar"]').val(data.gambar);
      $('input[name="harga"]').val(data.harga);
      $('input[name="diskon"]').val(data.diskon);
      $('input[name="bahan"]').val(data.bahan);
      $('input[name="tags"]').val(data.tags);
      $('input[name="sku"]').val(data.sku);
      $('input[name="ukuran"]').val(data.ukuran);
      $('input[name="warna"]').val(data.warna);
     
    });

    $('.form-kategori').submit(function(e)
    {
      e.preventDefault();
      const token = localStorage.getItem('token');
      const frmdata = new FormData(this);
      $.ajax({
        url :'/api/produk/'+id,
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
              window.location.href = '/produk';
            }
        
        },
        error: function(data)
        {
          console.log(data)
         // alert(data);
        }
      });
    });
  });

  
  $("#tambah").on("click", function() 
  {
    $('#methodkirim').remove(); //add input box
    $('input[name="nama_produk"]').val('');
    $('input[name="deskripsi"]').val('');
    $('#modal-form').modal('show');
    $('.form-kategori').submit(function(e)
    {
      e.preventDefault();
        const token = localStorage.getItem('token');
        const frmdata = new FormData(this);
        $.ajax({
          url :'/api/produk',
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
              window.location.href = '/produk';
            }
          }
        });
    });
  });
});

  
</script>
@endpush