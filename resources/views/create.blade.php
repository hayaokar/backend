

    <h1>Create country</h1>


    {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\AdminCountry@store','files'=>true]) !!}
    @csrf



    <div class="form-group">

        {!!  Form::label('name', 'Name:')!!}
        {!! Form::text('name',null,['class'=>'form-control']) !!}

    </div>



    <div class="form_group">

        {!!  Form::label('photo_id', 'Photo')!!}
        {!! Form::file('photo_id',null,['class'=>'form-control']) !!}

    </div>




    <div class="form_group">

        {!! Form::submit('create country',['class'=>'btn btn-primary']) !!}

    </div>



    {!! Form::close() !!}







