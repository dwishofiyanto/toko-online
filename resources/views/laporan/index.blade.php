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


    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr><th>No</th><th>Nama Barang</th><th>Harga</th><th>Jumlah Dibeli</th>
                <th>Pendapatan</th>
                <th>QTY</th>
                </tr>
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
      success : function({data})
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
        $('tbody').append(row);
      }
    });
  }
});

  
</script>
@endpush