// This script is used to show and hide the password when we click on the eye icon from fontawesome
const pswrdField = document.querySelector(".form input[type='password']"),
toggleIcon = document.querySelector(".form .field i");

// If the eye icon is clicked we change the input field type from password to text then add the active class to the eye & vice versa
toggleIcon.onclick = () =>{
  if(pswrdField.type === "password"){
    pswrdField.type = "text";
    toggleIcon.classList.add("active");
  }else{
    pswrdField.type = "password";
    toggleIcon.classList.remove("active");
  }
}
