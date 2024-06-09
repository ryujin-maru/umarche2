@props(['errors'])
@if($errors->any())
    <div {{$attributes}}>
    <ul>
        {{-- @php dd($errors) @endphp --}}
        @foreach($errors->all() as $error)
            <li class="mt-3 text-red-500">{{$error}}</li>
        @endforeach
    </ul>
    </div>
@endif