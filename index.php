<?php session_start(); ?>
<html>
<head><title>Photo World</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

</head>
<body>

<div class="jumbotron">
  <div class="container">
    <h2>Enter Details</h2>
  </div>
</div>
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="result.php" method="POST" class="form-">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <div class="form-group">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    <!-- Name of input element determines name in $_FILES array -->
    <label for="inputEmail3" class="col-sm-2 control-label">Choose File:</label>
    <div class="col-sm-10"> <input name="userfile" type="file"/>
    <p class="help-block">Ex:.png,.jpeg,.jpg,..</p>
    </div> </div>
    <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email:</label>
    <div class="col-sm-10"> <input type="email" name="useremail" class="form-control" width=200  placeholder="example@example.com">
    </div>
    </div>
    <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Phone Number:</label>
    <div class="col-sm-10"> <input type="phone" name="phone" class="form-control" width=200  placeholder="+1 (xxx)-(xxx)-xxxx">
    </div> </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <input type="submit" value="Send File" class="btn btn-default" />
    </div>
    </div>
    
</form>
<form enctype="multipart/form-data" action="sns.php" method="POST" class="form-">
<div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Enter your number to get notification of your images</label></br>
    <label for="inputEmail3" class="col-sm-2 control-label">Phone Number:</label>
    <div class="col-sm-10"> <input type="phone" name="phone" class="form-control" width=200  placeholder="19876543210">
    </div> </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <input type="submit" value="Send File" class="btn btn-default" />
    </div>
    </div>
</form>
<hr />
<div class="form-group">
    <a href="introspection.php"><label for="inputEmail3" class="col-sm-2 control-label">Click here for </label></a>
<hr />
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="gallary.php" method="POST" class="form-inline">
 <div class="form-group">
    <label for="inputEmail3">Enter Email Id for Images:</label>
    <input type="email" name="email" class="form-control" placeholder="example@example.com">
    </div>
    <input type="submit" value="Load Gallery" class="btn btn-primary"/>
</form>



</body>
</html>
