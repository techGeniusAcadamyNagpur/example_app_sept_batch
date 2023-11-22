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
        
    <h1>Blogs</h1>

    <form action="{{url('update-blog')}}" method=POST enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id" value="{{$blog[0]->id}}">
        <label for="">Title of the Blog</label><br>
        <input type="text" name="title" id="title" value="{{$blog[0]->title}}"> <br>

        <label for="">Write Description of the Blog</label><br>
        <textarea name="description" id="description" cols="30" rows="10">{{$blog[0]->description}}</textarea><br>

        <label for="">Upload An Image</label><br>
        <img src="{{url('uploads/'.$blog[0]->image)}}" alt="" width=200 height=200>
        <input type="file" name="image" id="image"><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>