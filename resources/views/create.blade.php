

    <h1>Create country</h1>


    {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\loginController@register','files'=>true]) !!}
    @csrf



    <div class="form-group">

        {!!  Form::label('name', 'Name:')!!}
        {!! Form::text('name',null,['class'=>'form-control']) !!}

    </div>

    <div class="form-group">

        {!!  Form::label('email', 'email:')!!}
        {!! Form::text('email',null,['class'=>'form-control']) !!}

    </div>

    <div class="form-group">

        {!!  Form::label('password', 'password:')!!}
        {!! Form::text('password',null,['class'=>'form-control']) !!}

    </div>

    <div class="form-group">

        {!!  Form::label('phone', 'phone:')!!}
        {!! Form::text('phone',null,['class'=>'form-control']) !!}

    </div>

    <div class="form-group">

        {!! Form::label('gender', 'gender:')!!}
        {!! Form::text('gender',null,['class'=>'form-control']) !!}

    </div>
    <div class="form-group">

        {!! Form::label('role_id', 'role_id:')!!}
        {!! Form::text('role_id',null,['class'=>'form-control']) !!}

    </div>

    <div class="form-group">

        {!! Form::label('address', 'address:')!!}
        {!! Form::text('address',null,['class'=>'form-control']) !!}

    </div>
    <div class="form_group">

        {!!  Form::label('certificates', 'certificates')!!}
        {!! Form::file('certificates',null,['class'=>'form-control']) !!}

    </div>



    <div class="form_group">

        {!! Form::submit('create country',['class'=>'btn btn-primary']) !!}

    </div>



    {!! Form::close() !!}







