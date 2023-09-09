


async function getMessages(params) {

 
  
   
  
    setTimeout(function(){
      try{
        const xhttp = new XMLHttpRequest();
      
      xhttp.open("GET", `http://localhost:8000/api/message-friend/${params[0]}`);
      xhttp.setRequestHeader('Authorization', `Bearer ${params[1]}`);
       xhttp.send();
      
      xhttp.onload = function() {
      postMessage( xhttp.responseText);
      
      getMessages(params)

      }
      }catch(err){
        console.log(err)
      }
    },2000);
  
  


  
}
function callMain(){
  onmessage = (event) => {
    const value = event.data;
    getMessages(value)
  }
}
callMain()