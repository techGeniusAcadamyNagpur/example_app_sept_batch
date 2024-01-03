<div id="copyright text-right">© Copyright 2017 Tech G new  </div>

<script>
    function addition() {
        var value_one = document.getElementById('value1').value;
        var value_two = document.getElementById('value2').value;

        var result = parseInt(value_one) + parseInt(value_two);

        document.getElementById("result").innerHTML = result;
        //alert(result);
    }

</script>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>



<script>
function postData() {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response=JSON.parse(xhr.responseText)
        var status=response.status;
        var data=response.data;

        if(status===200){
//details
        var fname=data.name;
        var lname=data.lname;
        var hobbies=data.hobbies;

        document.getElementById("status").innerHTML = response.message;

        document.getElementById("fname").innerHTML = fname;
        document.getElementById("lname").innerHTML = lname;
        document.getElementById("hobbies").innerHTML = hobbies;

        //console.log(fname);
        }else{
            document.getElementById("status").innerHTML = response.message;

            document.getElementById("fname").innerHTML = "";
            document.getElementById("lname").innerHTML = "";
            document.getElementById("hobbies").innerHTML = "";
        }

      } else {
        console.error('Request failed with status:', xhr.status);
      }
    }
  };

  xhr.open('POST', 'http://localhost:8000/api/user-detail', true);
  xhr.setRequestHeader('Content-Type', 'application/json');

  var person_name_input = document.getElementById('person_name_input').value;

  var dataToSend = {
    fname : person_name_input
  };

  xhr.send(JSON.stringify(dataToSend));
}


</script>