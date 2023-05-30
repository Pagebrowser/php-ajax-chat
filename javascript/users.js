// This script works with the search bar
const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
usersList = document.querySelector(".users-list");

searchIcon.onclick = ()=>{
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if(searchBar.classList.contains("active")){
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}


searchBar.onkeyup = ()=>{
  // We start by setting the search term to the value inserted in the search bar
  let searchTerm = searchBar.value;
  // If the search bar is not empty we set the search bar class to active and vice versa
  if(searchTerm != ""){
    searchBar.classList.add("active");
  }else{
    searchBar.classList.remove("active");
  }
  // We start by creating an XML object xhr
  let xhr = new XMLHttpRequest();
  // We open the XML object passing in the method, url and async
  xhr.open("POST", "php/search.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
}

// User dynamics with AJAX
setInterval(() =>{
  // We start by creating an XML object xhr
  let xhr = new XMLHttpRequest();
  // We open the XML object passing in the method, url and async
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          // If the search bar contains the class active we add this data in the innerHTML of the class user_list in users.php
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500); //This function will run frequetly after 500ms hence enabling the chat to seem realtime coz its very fast for the normal eye
