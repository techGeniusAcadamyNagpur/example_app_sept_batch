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

    <form action="{{url('create-blog')}}" method=POST enctype="multipart/form-data">
        @csrf
        <label for="">Title of the Blog</label><br>
        <input type="text" name="title" id="title" value=""> <br>

        <label for="">Write Description of the Blog</label><br>
        <textarea name="description" id="description" cols="30" rows="10"></textarea><br>

        <label for="">Upload An Image</label><br>
        <input type="file" name="image" id="image" accept="image/png, image/gif, image/jpeg"><br><br>

        <label for="">Upload Blog Manual PDF</label><br>
        <input type="file" name="blog_manual_pdf" id="blog_manual_pdf" accept="application/pdf"><br><br>

        <input type="submit">
    </form>

    <h1>Latest Blogs</h1>
    @foreach($blogs as $blog)
        <h2>{{$blog->title}}</h2>

        @if($blog->image!="")
        <img src="{{url('uploads/'.$blog->image)}}" alt="" width=200 height=200>
        @else
            <h1>No Image</h1>
        @endif

        <p>{{$blog->description}}</p>
         <br>
         <a href="{{url('edit-blog').'/'.$blog->id}}">edit</a>

         @if($blog->manual !="")
         <a href="{{url('blog_manuals').'/'.$blog->manual}}" target="_blank">Download Manual</a>
         @else
         <p>No Manual found</p>
         @endif
        
    @endforeach

</body>
</html>