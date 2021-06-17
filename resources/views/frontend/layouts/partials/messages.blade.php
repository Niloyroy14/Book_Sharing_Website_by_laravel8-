@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif


@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show mb-2 pt-3" role="alert">
	<p style="text-align: center;"><strong>{{Session::get('success')}}</strong></p>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
</div>
@endif





@if(Session::has('error'))
<div class="alert alert-danger mb-2 pt-3">
	<p style="text-align: center;"><strong>{{Session::get('error')}}</strong></p>
</div>
@endif