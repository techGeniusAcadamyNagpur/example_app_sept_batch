<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup page</title>
</head>
<body>
    <h1>Signup</h1>

    @if($errors->any())
        @foreach($errors->all() as $error)
         <h1 style="color:red">{{$error}}</h1>
         @endforeach
    @endif

    <form action="{{url('signup-save-data')}}" method="POST">
        @csrf

        <label for="">First Name</label>
        <input type="text" id="fname" name="fname" placeholder="Enter Your First Name" value="{{old('fname')}}" required> <br>

        <label for="">Middel Name</label>
        <input type="text" id="mname" name="mname" placeholder="Enter Your Middle Name" value="{{old('fname')}}" required> <br>

        <label for="">Grand Father Name</label>
        <input type="text" id="mname" name="mname" placeholder="Enter Your Grand Father" value="{{old('fname')}}" required> <br>

        <label for="">Last Name</label>
        <input type="text" id="lname" name="lname" placeholder="Enter Your Last Name" value="{{old('lname')}}"  required><br>

        <label for="">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter Your Email" value="{{old('email')}}"  required><br>

        <label for="">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter Your password" value="{{old('password')}}" required><br>

        <!-- radio group 1 -->
        <label for="">Gender</label>
        <input type="radio" id="gender" name="gender" value="M" @if(old('gender')=='M') checked @endif  ><label for="" required>Male</label>
        <input type="radio" id="gender" name="gender" value="F" @if(old('gender')=='F') checked @endif ><label for="" required>Female</label>
        <input type="radio" id="gender" name="gender" value="O" @if(old('gender')=='O') checked @endif><label for="" required>Other</label>

        <br>

        <!-- radio group 2 -->
        <label for="">Religion</label>
        <input type="radio" id="religion" name="religion" value="Hindu" @if(old('religion')=='Hindu') checked @endif required><label for="">Hindu</label>
        <input type="radio" id="religion" name="religion" value="Muslims" @if(old('religion')=='Muslims') checked @endif  required><label for="">Muslims</label>
        <input type="radio" id="religion" name="religion" value="Jain" @if(old('religion')=='Jain') checked @endif required><label for="">Jain</label><br>

        <!-- yha checkbox add krna hai -->
        <label for="">Hobbies</label>

        <input type="checkbox" name="hobbies[]" id="hobbies" value="Singing" {{ in_array('Singing', old('hobbies', [])) ? 'checked':''}} >Singing
        <input type="checkbox" name="hobbies[]" id="hobbies" value="Dancing" {{ in_array('Dancing', old('hobbies', [])) ? 'checked':''}}>Dancing
        <input type="checkbox" name="hobbies[]" id="hobbies" value="Cricket" {{ in_array('Cricket', old('hobbies', [])) ? 'checked':''}}>cricket

        <input type="checkbox" name="hobbies[]" id="hobbies" value="Cricket"  >cricket

        

        <br>
        <label for="">Enter Your aadhar number</label>
        <input type="number" id="aadhar" name="aadhar"  value="{{old('aadhar')}}" required>
        <br>
        <label for="">Country Code</label>
        <input type="number" id="country_code" name="country_code"  value="{{old('country_code')}}" required>
        <br>
        <label for="">Mobile No</label>
        <input type="number" id="mobile" name="mobile"  value="{{old('mobile')}}" required>
        <br>
        <input type="reset">
        <input type="submit">


        <br>

        <br>
    </form>
    <a href="{{url('login')}}">if you have account click to login</a>
</body>
</html>