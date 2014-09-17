<!doctype html>  
     <html>  
     <head>  
       <script>  
         function updateOnlineStatus(msg) {  
           var status = document.getElementById("status");  
           var condition = navigator.onLine ? "ONLINE" : "OFFLINE";  
      
           var state = document.getElementById("checker");  
           state.innerHTML = condition;  
        
         }  
         function loaded() {  
           updateOnlineStatus("load");  
           window.addEventListener("offline", function () {  
             updateOnlineStatus("offline")  
           }, false);  
           window.addEventListener("online", function () {  
             updateOnlineStatus("online")  
           }, false);  
         }  
       </script>  
     </head>  
     <body onload="loaded()">  
    <li>The Window Is: <span id="checker"></span></li>
     </body>  
     </html>  