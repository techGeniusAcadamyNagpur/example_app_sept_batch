<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
</head>
<body>
    
        @if($errors->any())
            @foreach($errors->all() as $error)
            <h1 style="color:red">{{$error}}</h1>
            @endforeach
        @endif

        @if(Session::has('success'))
        <h1 style="color:#0FFF50">{{Session::get('success')}}</h1>
        @endif

        @if(Session::has('fail'))
        <h1 style="color:#a51700">{{Session::get('fail')}}</h1>
        @endif
        
    <h1>Send offers</h1>

    <form action="{{url('send_offer')}}" method=POST enctype="multipart/form-data">
        @csrf
        <label for="">Title of the offer</label><br>
        <input type="text" name="title" id="title" value=""> <br>

        <label for="">Write Description of the offer</label><br>
        <textarea name="description" id="description" cols="30" rows="10"></textarea><br>

        <input type="submit">
    </form>
</body>
</html>