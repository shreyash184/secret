<?php
	
	session_start();

	$error = "";

	if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: loggedInPage.php");
        
    }

	if (array_key_exists("submit", $_POST)) {
      
      include("connection.php"); 
      
        if(!$_POST["email"]){

            $error .= "<p>An Email is required</p>";
        }
        if(!$_POST["password"]){

            $error .= "<p>The Password is required</p>";
        }	
        if($error != ""){

            $error = "<p>There are few requirement to be fullfilled<p/>".$error;
        } else {
          
	      	if($_POST['signUp'] == "1") {
          
          	$query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link , $_POST['email'])."' LIMIT 1 ";
          	$result = mysqli_query($link , $query);
              
          		if(mysqli_num_rows($result)>0){
                  
                  	$error .= "<p>This mail is already registerd<p/>";
                } else {
                  
              		$query = "INSERT INTO users (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
                  
                  	if(!mysqli_query($link , $query)) {
                      	
                      	$error .= "<p>Could not sign up please try again later</p>";
                    } else {
                  		
                      	$query = "UPDATE users SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
                      
                      	   mysqli_query($link , $query);
                      
                          	$_SESSION["id"] = mysqli_insert_id($link);
                          
                          	if($_POST["checkbox"] == '1') {
                              	
                              	setcookie("id", mysqli_insert_id($link) , time() + 60*60*24*365);
                              
                            } 
                          
                      		header("Location: loggedInPage.php");
                          
                    }
                }
            }
          	
        
          else  {
            
            	$query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'";
            
            	$result = mysqli_query($link, $query);
            
            	$row = mysqli_fetch_array($result);
            
            	if(isset($row)) {
                  	
                 	$hashedPassword = md5(md5($row['id']).$_POST['password']);
                  
                  	if($hashedPassword == $row['password']) {
                      		
                      		$_SESSION['id'] = $row['id'];
                      
                      		if($_POST['checkbox'] == '1') {
                              
                              		setcookie("id", $row['id'], time() + 60*60*24*365);
                            }
                      	
                      		header("Location: loggedInPage.php");
                    } else {
                      
                     		$error = "That email/password combination could not be found.";
                    }
                  		
                } else {
                  
                 		$error = "That email/password combination could not be found.";
                }
            	
          }
        }
}
?>

	<?php include("header.php"); ?>
    
    <div class="container">
      
      <h1>Secret Diary</h1>
      
            <div id="error">

              <?php

                  echo $error;

              ?>

          </div>

          <form method="post" id="signUpForm" >

            <div class="form-group"> 
            
              <input type="email" name="email" placeholder="Enter Your Email" class="form-control">
             
            </div>
            
            <div class="form-group">

              <input type="password" name="password" placeholder="password" class="form-control">
              
            </div>

            <input type="checkbox" name="checkbox" value=1> <p class ="stay">Stay Signed Up<br></p>

              <input type="hidden" name="signUp" value="1">

              <input type="submit" value="Sign Up" name="submit" class="btn btn-success">
            
            <p><input type="button" value="Log In" class="btn btn-primary toggleForm"></p>

          </form>

          <form method="post" id="logInForm" >
            
            <div class="form-group">

              <input type="email" name="email" placeholder="Enter Your Email" class="form-control">
              
            </div>
            
            <div class="form-group">

              <input type="password" name="password" placeholder="password" class="form-control">
              
            </div>

              <input type="checkbox" name="checkbox" value=1><p class ="stay">Stay Log In<br></p> 

              <input type="hidden" name="signUp" value="0">

              <input type="submit" value="Log In" name="submit" class="btn btn-success">
            
            <p><input type="button" value="Sign Up" class="btn btn-primary toggleForm"></p>

          </form>
      
    </div>

   <?php include("footer.php"); ?>