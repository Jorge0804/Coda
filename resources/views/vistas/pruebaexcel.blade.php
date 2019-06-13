@extends('vistas.base')

@section('contenido')
<form action="{{url('importarexcel')}}" method="GET" enctype="multipart/form-data">
	{{csrf_field()}}
	<input type="file" name="file">

	<button class="btn btn-primary" type="submit">Importar</button>
</form>
@endsection