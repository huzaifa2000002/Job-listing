@props(['tagsCsv'])
{{-- csv as in comma seprated value --}}
@php
$tags=explode(',',$tagsCsv);
// explode takes pram where we want to split the string since ist csv so we use comma
@endphp
<ul class="flex">
    @foreach($tags as $tag)
    <li
        class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
    >
        <a href="/?tag={{$tag}}">{{$tag}}</a>
    </li>
    {{--   /?tag={{$tag}} will redirect to particular tag--}}
    @endforeach
</ul>
