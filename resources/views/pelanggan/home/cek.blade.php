
@foreach ($data as $item)
<p>{{ $item['id'] }}</p>
@endforeach
{{$paginator->last_page}}
@foreach ($paginator as $p)
  
@endforeach


