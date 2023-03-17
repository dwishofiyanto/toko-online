<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel dynamic auto load more page scroll examle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5" style="max-width: 550px">
        <div id="data-wrapper">
            <!-- Results -->
        </div>
        <!-- Data Loader -->
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
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var ENDPOINT = "{{ url('/') }}";
        var page = 1;
        infinteLoadMore(page);
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                infinteLoadMore(page);
            }
        });
        function infinteLoadMore(page) {
    //         $.ajax({  
    //     type: "GET",
    //     url: "path_ke_file_query/data_per_load.php",
    //     data: "last_id : last_id", //last_id kita berarti 15
    //     dataType: "html",  //sesuai keinginan, di sini saya pengen ngambil langsung data dalam bentuk html langsung dari file data_per_load.php
    //     success: function(data){
    //         $('.auto-load').hide();
    //                 $("#data-wrapper").append(data);

    //         $(".class_div_hasil_fetch").append(data);
    //     }
    //   });

            $.ajax({
                    url: "http://localhost:8000/api/produk/?page=" + page,
                    datatype: "json",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function ({data}) {
                   // console.log(response.data);
                    if (data.length == 0) {
                        $('.auto-load').html("We don't have more data to display :(");
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper").append(data);
                    console.log(data);

                    jQuery.each(data,function(response, el) {
  //  console.log('nama '+el.nama+' umur'+el.umur);
  });

                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
    </script>
</body>
</html>