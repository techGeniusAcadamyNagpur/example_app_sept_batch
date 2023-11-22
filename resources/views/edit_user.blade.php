<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>

    @if($errors->any())
        @foreach($errors->all() as $error)
         <h1 style="color:red">{{$error}}</h1>
         @endforeach
    @endif

    <form action="{{url('update_user')}}" method="POST">
        @csrf

        <input type="hidden" name="id" id="id" value="{{$user_data[0]->id}}">

        <label for="">First Name</label>
        <input type="text" id="fname" name="fname" placeholder="Enter Your First Name" value="{{old('fname')}}{{$user_data[0]->name}}" required> <br>

        <label for="">Last Name</label>
        <input type="text" id="lname" name="lname" placeholder="Enter Your Last Name" value="{{old('lname')}}{{$user_data[0]->lname}}"  required><br>

        <label for="">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter Your Email" value="{{old('email')}}{{$user_data[0]->email}}"  required><br>

        <!-- radio group 1 -->
        <label for="">Gender</label>
        <input type="radio" id="gender" name="gender" value="M" @if(old('gender')=='M') checked @endif @if($user_data[0]->gender =='M') checked @endif><label for="" required>Male</label>
        <input type="radio" id="gender" name="gender" value="F" @if(old('gender')=='F') checked @endif @if($user_data[0]->gender =='F') checked @endif><label for="" required>Female</label>
        <input type="radio" id="gender" name="gender" value="O" @if(old('gender')=='O') checked @endif @if($user_data[0]->gender =='O') checked @endif><label for="" required>Other</label>

        <br>

        <!-- radio group 2 -->
        <label for="">Religion</label>
        <input type="radio" id="religion" name="religion" value="Hindu" @if(old('religion')=='Hindu') checked @endif @if($user_data[0]->religion =='Hindu') checked @endif required><label for="">Hindu</label>
        <input type="radio" id="religion" name="religion" value="Muslims" @if(old('religion')=='Muslims') checked @endif @if($user_data[0]->religion =='Muslims') checked @endif required><label for="">Muslims</label>
        <input type="radio" id="religion" name="religion" value="Jain" @if(old('religion')=='Jain') checked @endif @if($user_data[0]->religion =='Jain') checked @endif required><label for="">Jain</label><br>

        <!-- yha checkbox add krna hai -->
        <label for="">Hobbies</label>
        @php
            $hobbies=$user_data[0]->hobbies;
            $hobbies_array=explode(', ', $hobbies);
        @endphp
        <input type="checkbox" name="hobbies[]" id="hobbies" value="Singing" {{ in_array('Singing', old('hobbies', [])) ? 'checked':''}} {{ in_array('Singing', $hobbies_array) ? 'checked':''}} >Singing
        <input type="checkbox" name="hobbies[]" id="hobbies" value="Dancing" {{ in_array('Dancing', old('hobbies', [])) ? 'checked':''}} {{ in_array('Dancing', $hobbies_array) ? 'checked':''}}>Dancing
        <input type="checkbox" name="hobbies[]" id="hobbies" value="Cricket" {{ in_array('Cricket', old('hobbies', [])) ? 'checked':''}} {{ in_array('Cricket', $hobbies_array) ? 'checked':''}}>cricket

        <input type="checkbox" name="hobbies[]" id="hobbies" value="Cricket"  >cricket

        

        <br>
        <label for="">Enter Your aadhar number</label>
        <input type="number" id="aadhar" name="aadhar"  value="{{old('aadhar')}}{{$user_data[0]->addhar_no}}" required>
        <br>
        <label for="">Country Code</label>
        <input type="number" id="country_code" name="country_code"  value="{{old('country_code')}}{{$user_data[0]->country_code}}" required>
        <br>
        <label for="">Mobile No</label>
        <input type="number" id="mobile" name="mobile"  value="{{old('mobile')}}{{$user_data[0]->mobile_no}}" required>
        <br>
        <input type="reset">
        <input type="submit">


        <br>

        <br>
    </form>
    <a href="{{url('login')}}">if you have account click to login</a>
</body>
</html>