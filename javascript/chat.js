const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                inputField.value = "";//Once msg is inserted into the db then leave/clear the input field blank
                scrollToBottom();
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

// User dynamics with AJAX
setInterval(() => {
    // We start by creating an XML object xhr
    let xhr = new XMLHttpRequest();
    // We open the XML object passing in the method, url and async
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML = data;
                // If the chatBox contains the class active we call the scrollToBottom method
                if(!chatBox.classList.contains("active")){
                    scrollToBottom();
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 500);//This function will run frequetly after 500ms hence enabling the chat to seem realtime coz its very fast for the normal eye

