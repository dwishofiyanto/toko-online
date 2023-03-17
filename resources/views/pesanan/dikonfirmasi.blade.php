@extends('layout.app')
@section('titile','Data Pesanan Dikonfirmasi')
@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Data Pesanan Dikonfirmasi</h4>
    </div>


<div class="card-body">
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
          status : 'Dikemas'
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
      url :'/api/pesanan/dikonfirmasi',
      headers :
        {
          'Authorization' : 'Bearer '+ token
        },
        beforeSend: function()
        {
          $('.auto-load').show();
        },
      success : function({data})
      {
        $('.auto-load').hide();
        if(data.length == 0)
        {
          $('tbody').append('<p>Tidak ada data</p>');
        }
        else
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
                  <td><a id="konfirmasi" data-id="${val.id}" class="btn btn-warning tombol-aksi">KEMAS</a> </td>
             </tr>`;
        });
        $('thead').append(`  <tr><th>No</th><th>Tanggal Pesanan</th><th>Invoice</th><th>Pelanggan</th><TH>Total</th><th>Status</TH></tr>`);
        $('tbody').append(row);
      }}
    });
  }
});
</script>
@endpush
