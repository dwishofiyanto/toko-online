@extends('layout.app')
@section('titile','Laporan')
@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Laporan</h4>
    </div>


<div class="card-body">

<div class="row">
  <div class="col-md-6">
    <form>
      <div class="form-group">
        <label for="">Dari </label>
        <input type="date" name="dari" id="dari" class="form-control" value="{{request()->input('dari')}}">
      </div>

      <div class="form-group">
        <label for="">Sampai  </label>
        <input type="date" name="sampai" id="sampai" class="form-control" value="{{request()->input('sampai')}}">
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">CARI</button>
      </div>
    </form>
  </div>
</div>


   @if(request()->input('dari'))
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

   @endif


@endsection
@push('js')
<script>
    function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function rupiah(bilangan)
  {
    var	number_string = bilangan.toString(),
    split	= number_string.split(','),
    sisa 	= split[0].length % 3,
    rupiah 	= split[0].substr(0, sisa),
    ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
    return rupiah =  split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  }
$(document).ready(function()
{
  const token = localStorage.getItem('token');
  const dari = '{{request()->input('dari')}}';
  const sampai = '{{request()->input('sampai')}}';
  // const dari = '2022-02-02';
  // const sampai = '2023-09-09';
  tampil_data();
 function tampil_data(){
    $.ajax({
      url :'/api/laporan?dari='+dari+'&sampai='+sampai,
      headers :
        {
          'Authorization' : 'Bearer '+ token
        },
        beforeSend: function()
        {
          $('.auto.load').show();
        },
      success : function({data})
      {
        $('.auto-load').hide();
        if(data.length == 0)
        {
          $('tbody').append('<P>Tidak ada data</p>');
        }
        else
        {
        let row;
        data.map(function(val, index)
        {
          row += `<tr>
                  <td>${index+1}</td>
                  <td>${val.nama_barang}</td>
                  <td> Rp. ${rupiah(val.harga)}</td>
                  <td>${val.jumlah_dibeli}</td>
                  <td> Rp. ${rupiah(val.pendapatan)}</td>
                  <td>${val.total_qty}</td>
                  </tr>`;
        });
        $('thead').append(` <tr><th>No</th><th>Nama Barang</th><th>Harga</th><th>Jumlah Dibeli</th>
                <th>Pendapatan</th>
                <th>QTY</th>
                </tr>`);
        $('tbody').append(row);
      }}
    });
  }
});

  
</script>
@endpush