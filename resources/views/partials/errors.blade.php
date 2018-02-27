@if (count($errors)>0)
<div class="alert alert-danger mt-2" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif