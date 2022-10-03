<x-layout>
    {{-- @extends('layout')
    @section('content') --}}
    @include('partials._hero')
    @include('partials._search')
    {{-- <h1>lisitings.blade.php</h1> --}}
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

{{-- <h1>{{$heading}}</h1> --}}
@if(count($listings) == 0)
<p>No listings found.</p>
@endif
@foreach ($listings as $listing)

<x-listing-card :listing='$listing'/>

{{-- gives refrence to listing-card.blade.php of variable 'listing' the ':' is used to connect hte teo part where as 'x-listing is used as syntax'  --}}
@endforeach
</div>
<div class="mt-6 p-4 left-1/2">
{{$listings->links()}}
</div>


{{-- @endsection --}}
</x-layout>
