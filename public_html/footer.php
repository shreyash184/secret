<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    
    <script type="text/javascript">
      
      	$(".toggleForm").click(function() {
          
          	$("#signUpForm").toggle();
          	
          	$("#logInForm").toggle();
          
        });
      
      	$("#diary1").bind('input propertychange', function() {
         $.ajax({
                  method: "POST",
                  url: "updatedatabase.php",
                  data: { content: $("#diary1").val() }
                }).done(function( msg ) {
           		alert("hi" + msg );
         	});
          	
        });
      
    </script> 
    
  </body>
</html>