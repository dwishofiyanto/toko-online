<table>
    <thead>
        <th>KATEGORI</th>
        <TH>SUB KATEGORI</TH>
    </thead>
    <TBOdy>
        @foreach($kategori as $kategori)
    <tr>
        <td>{{$kategori->nama_kategori}}</td>
        <td>
            @foreach($kategori->subkategori1 as $sub)
                ,{{$sub->nama_subkategori}}
            @endforeach
        </td>
    </tr>
        @endforeach
    </TBOdy>
</table>