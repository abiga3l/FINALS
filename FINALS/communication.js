function sendMessage(){
    const messageInput =document.getElementById('messageInput');
    if(messageInput.value.trim()!== ''){
      const messageElement =document.createElement('div');
      messageElement.classList.add('message','me');
      messageElement.textContent =messageInput.value;
      messageContainer.appendChild(messageElement);
      messageInput.value = '';
      
   messageContainer.scrollTop =messageContainer.scrollHeight;
    }else{
      alert('Please type a message');
   
    }
  }