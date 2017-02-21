<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Gov2.0 Shared Service</title>	
	<!-- bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">	
	<!-- libraries -->
	<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	<!-- global styles -->
	<link rel="stylesheet" type="text/css" href="css/login.css" />
  <link rel="stylesheet" type="text/css" href="css/wizard.css" />
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>

</head>
<body>

  <div id="main-container" class="container">			
    <iframe id="iframer" name="iframer" src="" frameborder="1" style="display:<?if ($_GET['debug']) {echo "inline";} else {echo "none";}?>" width="300" height="200"></iframe>
     
    <div class="row">
        <div class="col-xd-12">          
      <?
      if (is_array($doc->content))  {
        while (list($key,$val)=each($doc->content)) {
            if ($val && file_exists($val)) {include($val);}
            else {echo $val;}
        }
      } elseif (!$doc->error && !$doc->content) {?>
          <div>Under Construction</div>
      <?} else {echo $doc->content;}?>					
        </div>
    </div>
  </div>
	
	<!-- JavaScript Files -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/wizard.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>

<script type="text/javascript" src="js/iframeResizer.contentWindow.min.js"></script>
<script type="text/javascript">
    var onloadCallback = function() {
    grecaptcha.render('html_element', {
          'sitekey' : '<?echo $config->recaptcha->sitekey;?>'
        });
    };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=id"
    async defer>
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        var currentdate = new Date(); 
        var datetime = currentdate.getDate() + "/"
                    + currentdate.getMonth()  + "/"
                    + currentdate.getFullYear() + " @ "
                    + currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + (currentdate.getSeconds()+10);

       $("#getting-started").countdown(datetime, function(event) {
             $(this).text(
               event.strftime('%M:%S')
             );
            if (event.strftime('%M:%S')=="00:00") {$("#getting-started").countdown('pause');} 
       });
    });
 </script>
</body>
</html>