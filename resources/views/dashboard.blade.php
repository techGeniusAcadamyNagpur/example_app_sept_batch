<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .user_navigation{
            float: right;
        }
        .header{
            background-color: #00ff78;
            padding: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
        @if(Session::has('success'))
        <h1 style="color:#0FFF50">{{Session::get('success')}}</h1>
        @endif

        @if(Session::has('fail'))
        <h1 style="color:#a51700">{{Session::get('fail')}}</h1>
        @endif
        
    <header class="header">
        <img src="{{url('app_meta/wlogo.png')}}" alt="" width=100 height=50>
        <lable class="user_navigation">{{$fname}} {{$lname}} <a href="{{url('logout')}}">Logout</a</lable>
    </header>

    <h2><a href="{{url('blogs')}}">Blogs</a></h2>

    <table border=1>
        <tr>
            <th>id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
        </tr>

        @foreach($users_data as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->lname}}</td>
            <td>{{$user->gender}}</td>
            <td><a href="{{url('delete_user/'.$user->id)}}">Delete</a></td>
            <td><a href="{{url('edit_user/'.$user->id)}}">Edit</a></td>
        </tr>
        @endforeach

    </table>




</body>
</html>