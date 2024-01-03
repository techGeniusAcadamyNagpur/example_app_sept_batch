@extends('layouts.admin')

@section('content')
<!-- write main code -->
<style>
    .login_btn{
        /* Button */

position: absolute;
width: 307px;
height: 44px;
left: 34px;
top: 468px;



/* Rectangle */

position: absolute;
left: 0%;
right: 0%;
top: 0%;
bottom: 0%;

background: #3797EF;
border-radius: 5px;


/* Log in */

position: absolute;
height: 17px;
left: 43.32%;
right: 43.32%;
top: calc(50% - 17px/2 + 0.5px);

font-family: 'SF Pro Text';
font-style: normal;
font-weight: 600;
font-size: 14px;
line-height: 17px;
/* identical to box height */
text-align: center;
letter-spacing: -0.15px;

color: #FFFFFF;


    }

    .user_image{
        /* User */

position: absolute;
width: 85px;
height: 115px;
left: 145px;
top: 341px;



/* jacob_w */

position: absolute;
height: 17px;
left: 42.93%;
right: 42.93%;
top: calc(50% - 17px/2 + 41.5px);

font-family: 'SF Pro Text';
font-style: normal;
font-weight: 600;
font-size: 14px;
line-height: 17px;
/* identical to box height */
text-align: center;
letter-spacing: -0.15px;

color: #262626;



/* Oval */

box-sizing: border-box;

position: absolute;
left: 38.67%;
right: 38.67%;
top: 42%;
bottom: 47.54%;

background: url(Image.png);
border: 0.5px solid rgba(0, 0, 0, 0.1);

    }

    .password{
        /* Password */

position: absolute;
left: 4.27%;
right: 4.27%;
top: 38.42%;
bottom: 56.16%;



/* Rectangle */

box-sizing: border-box;

position: absolute;
left: 0%;
right: 0%;
top: 0%;
bottom: 0%;

background: #FAFAFA;
border: 0.5px solid rgba(0, 0, 0, 0.1);
border-radius: 5px;


/* Password */

position: absolute;
height: 17px;
left: 4.37%;
right: 77.26%;
top: calc(50% - 17px/2);

font-family: 'SF Pro Text';
font-style: normal;
font-weight: 400;
font-size: 14px;
line-height: 17px;
/* identical to box height */
letter-spacing: -0.15px;

color: rgba(0, 0, 0, 0.2);


    }

    .login_form{
        /* Form */

position: absolute;
width: 343px;
height: 262px;
left: 16px;
top: 256px;



/* Facebook Log in */

position: absolute;
left: 27.47%;
right: 27.47%;
top: 61.58%;
bottom: 36.21%;



/* Icon */

position: absolute;
width: 17px;
height: 17px;
left: 0px;
top: 0px;



/* Shape */

position: absolute;
left: 0%;
right: 89.94%;
top: 0%;
bottom: 5.56%;

background: #3797EF;


/* Log in with Facebook */

position: absolute;
height: 17px;
left: 15.98%;
right: 0%;
top: calc(50% - 17px/2 + 1px);

font-family: 'SF Pro Text';
font-style: normal;
font-weight: 600;
font-size: 14px;
line-height: 17px;
/* identical to box height */
letter-spacing: -0.15px;

color: #3797EF;



/* Forgot password? */

position: absolute;
height: 14px;
left: 67.47%;
right: 4.27%;
top: calc(50% - 14px/2 - 24px);

font-family: 'SF Pro Text';
font-style: normal;
font-weight: 500;
font-size: 12px;
line-height: 14px;
text-align: right;
letter-spacing: 0.15px;

color: #3797EF;



/* Username */

position: absolute;
left: 4.27%;
right: 4.27%;
top: 31.53%;
bottom: 63.05%;



/* Rectangle */

box-sizing: border-box;

position: absolute;
left: 0%;
right: 0%;
top: 0%;
bottom: 0%;

background: #FAFAFA;
border: 0.5px solid rgba(0, 0, 0, 0.1);
border-radius: 5px;


/* asad_khasanov */

position: absolute;
height: 17px;
left: 4.37%;
right: 66.76%;
top: calc(50% - 17px/2);

font-family: 'SF Pro Text';
font-style: normal;
font-weight: 400;
font-size: 14px;
line-height: 17px;
/* identical to box height */
letter-spacing: -0.15px;

color: #262626;



/* Password */

position: absolute;
left: 4.27%;
right: 4.27%;
top: 38.42%;
bottom: 56.16%;



/* Rectangle */

box-sizing: border-box;

position: absolute;
left: 0%;
right: 0%;
top: 0%;
bottom: 0%;

background: #FAFAFA;
border: 0.5px solid rgba(0, 0, 0, 0.1);
border-radius: 5px;


/* Password */

position: absolute;
height: 17px;
left: 4.37%;
right: 77.26%;
top: calc(50% - 17px/2);

font-family: 'SF Pro Text';
font-style: normal;
font-weight: 400;
font-size: 14px;
line-height: 17px;
/* identical to box height */
letter-spacing: -0.15px;

color: rgba(0, 0, 0, 0.2);



/* Button */

position: absolute;
left: 4.27%;
right: 4.27%;
top: 51.6%;
bottom: 42.98%;

mix-blend-mode: normal;
opacity: 0.5;


/* Rectangle */

position: absolute;
left: 0%;
right: 0%;
top: 0%;
bottom: 0%;

background: #3797EF;
border-radius: 5px;


/* Log in */

position: absolute;
height: 17px;
left: 44.02%;
right: 44.02%;
top: calc(50% - 17px/2 + 0.5px);

font-family: 'SF Pro Text';
font-style: normal;
font-weight: 600;
font-size: 14px;
line-height: 17px;
/* identical to box height */
text-align: center;
letter-spacing: -0.15px;

color: #FFFFFF;


    }
</style>
<body>
    <h2><a href="{{ url('blogs') }}">Blogs</a>
        <a href="{{ url('send_offer_dashboard') }}">Send Offers Dashboard</a></h2>

    <table border=1>
        <tr>
            <th>id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
        </tr>

        @foreach($users_data as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->lname }}</td>
                <td>{{ $user->gender }}</td>
                <td><a href="{{ url('delete_user/'.$user->id) }}">Delete</a></td>
                <td><a href="{{ url('edit_user/'.$user->id) }}">Edit</a></td>
            </tr>
        @endforeach

    </table>


    <h1>Calculator</h1>


    <!-- Trigger/Open The Modal -->
    <button id="myBtn">Addition</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Addition</h2>
            <form action="">
                <input type="text" name="value1" id="value1" placeholder="enter value1" value=""> +
                <input type="text" name="value2" id="value2" placeholder="enter value2" value="">
                <input type="button" value="add" onClick="addition()">
                <p id="result"></p>
            </form>
        </div>

    </div>

    <br>
    <h1>Search Users By Name</h1>
    <input type="text" id="person_name_input" />
<button  onclick="postData()">Get Data</button>

<img src="https://i.pinimg.com/1200x/64/81/22/6481225432795d8cdf48f0f85800cf66.jpg" class="user_image" alt="">

<form action="" class="login_form">
<input type="text" class="password" value="hiiiiiii">
<a href="" class="login_btn">Login</a>
</form>



<h1 id="status"></h1>
<p id="fname"></p>
<p id="lname"></p>
<p id="hobbies"></p>

</body>
@stop
