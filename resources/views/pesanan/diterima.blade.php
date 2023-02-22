@extends('layout.app')
@section('titile','Data Pesanan Diterima')
@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Data Pesanan Diterima</h4>
    </div>


<div class="card-body">
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr><th>No</th><th>Tanggal Pesanan</th><th>Invoice</th><th>Pelanggan</th><TH>Total</th><th>Status</TH></tr>
            </thead>
            <tbody id="tampil_data"></tbody>
        </table>
    </div>

</div>
</div>
@endsection
@push('js')
<script>
function setCookie(cname, cvalue, exdays) 
{
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

$(document).ready(function()
{
  const token = localStorage.getItem('token');
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
  function date(date)
  {
    var date = new Date(date);
    var day = date.getDate();
    var mont = date.getMonth();
    var year = date.getFullYear();
    return `${day}-${mont}-${year}`;
  }
  tampil_data();
  $("#tampil_data").on("click",".tombol-aksi", function() 
  {
    const id = $(this).data('id');
    const token = localStorage.getItem('token');
     $.ajax({
        url :'/api/pesanan/ubah_status/'+id,
        type : 'post',
        
        data : {
          status : 'Selesai'
        },
        
        headers :{
          'Authorization' : 'Bearer '+ token
        },
        success : function(data){
          location.reload();
         // console.log(data)
        }
     });
   });
      
      
  function tampil_data(){
   $.ajax({
      url :'/api/pesanan/diterima',
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
                  
                  <td>${date(val.created_at)}</td>
                  <td>${val.invoice}</td>
                  <td>${val.pelanggan.nama_pelanggan}</td>
                  <td>Rp. ${rupiah(val.grand_total)}</td>
                  <td><a id="konfirmasi" data-id="${val.id}" class="btn btn-warning tombol-aksi">SELESAIKAN</a> </td>
             </tr>`;
        });
        $('tbody').append(row);
      }
    });
  }
});
</script>
@endpush
