 <!-- 
Autor: Cristian Leonardo Baini.

 -->
 <!DOCTYPE html>
 <html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">   
   <link rel="stylesheet"  type = "text/css" href="css/bootstrap.min.css">
   
   <link rel="stylesheet"  type = "text/css" href="css/estilos2.css">
   <script src="js/leaflet.js"></script>  
   <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
   <link rel="icon" href="prosegur.png">  
   <title>GEOALARMAS 2.0</title>
 </head>
 <body>
 
 


<div class="wrapper fadeInDown">
  
    
  <div id="formContent">
 
<div class="fadeIn first">
      <img src="prosegur.png" id="icon" alt="User Icon"  />
    </div>
   

   
    <form action="rec_login.php" method="POST">
      <h1>GEOALARMAS</h1>
      <input type="text" id="username" class="fadeIn second" name="username" placeholder="login">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>

   
    <div id="formFooter">
      <a class="underlineHover" href="docs/Diagrama general.htm">VERSION 2.0 || DOCS</a>
    </div>
    

  </div>
</div>


 </body>
 </html>