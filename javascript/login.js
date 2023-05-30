const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

// This error prevents the form from submitting
form.onsubmit = (e)=>{
    e.preventDefault();
}

// Now lets submit the form using AJAX
continueBtn.onclick = ()=>{
    // We start by creating an XML object xhr
    let xhr = new XMLHttpRequest();
    // We open the XML object passing in the method, url and async
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "success"){
                //When the data is successfully submitted the page redirects to users.php page
                location.href="users.php";
              }else{
                errorText.style.display = "block";
                errorText.textContent = data;
              }
          }
      }
    }
    // Lastly we send the formData thru ajax to php
    let formData = new FormData(form);// We start by creating new formData object
    xhr.send(formData);// Lastly we send the formData to php
}