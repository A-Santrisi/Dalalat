<!DOCTYPE html>
<html lang="ar" dir="rtl" xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dlalat دلالات</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
	  		    <link rel="shortcut icon" href="images/logo2.png"/>


<style>
@font-face {
   font-family: myFirstFont;
   src: url(fonts/NotoKufiArabic-Regular.ttf);
   font-size:8px;
}
body {
   font-family: myFirstFont;
}

</style>
</head>

<body >
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">

                                 <center> <a class="navbar-brand" href="index.php">Dlalat دلالات</a>

            
        </nav>

        <div id="page-wrapper" >
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           <Center><img src="images/logo.png" width="15%"/>
Dlalat دلالات <img src="images/logo.png" width="15%"/>

                        </h1>
					
                    </div>
                </div>
				
				
                <!-- /. ROW  -->

              
				
				<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						<center>
 أدخل سؤالك باللغة العربية

  </div>
						<div class="panel-body">

<center>




 <form action="#" method="post">
 
 
  <div class="form-group">
                                            <label>السؤال</label>
  
                                                 <input type="text" name="question" id="question"  class="form-control" required>

                                        </div>
										
										
							 <div class="form-group">
  										        <input type="submit" class="btn btn-primary" value="اسأل">


                                        </div>			
       
	
										
                                     
                                       
										

                                    </form>
									
									
									
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$pythonPath = 'C:/Users/LEGION/anaconda3/envs/PRProject/python.exe';
    $pythonScriptPath = 'C:/Users/LEGION/OneDrive - University Of Jordan/Dalalat/main.py';
    $command = $pythonPath . ' ' . escapeshellarg($pythonScriptPath) . ' ' . escapeshellarg($_POST['question']);
    $output = shell_exec($command);
    $decodedAnswers = json_decode($output, true);
    echo " السؤال: " . $_POST['question'] . "<br>";
    // Display answers
    if (isset($decodedAnswers['answers'])) {
        $answers = $decodedAnswers['answers'];
		$relPassagesText = $decodedAnswers['relevant_passages'];
        for ($id=0;$id<=count($answers)-1;$id++) {
            echo "<div style='background-color: #FFFFE0; padding: 5px; margin-bottom: 10px;'>";
			echo "<b> النص القرآني:</b> " . highlightText($relPassagesText[$id], $answers[$id]) . "<br>";
			echo "<b> الاجابة:</b> " . highlightText($answers[$id], $_POST['question']) . "<br>";
            echo "</div>";
			}
    } else {
        $api_key = "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";
	    $openai_api_url = "https://api.openai.com/v1/chat/completions";
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer $api_key",
        ];
 
        $question2 = 'اذكر رقم السورة ورقم الاية ونص الاية التي تدل على'.$_POST['question'].' من القران الكريم';
 
        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role" => "system", "content" => "You are a helpful assistant."],
                ["role" => "user", "content" => $question2],
            ],
        ];
 
        $curl = curl_init($openai_api_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
 
        $api_response2 = curl_exec($curl);
        curl_close($curl);
 
        $api_response2 = json_decode($api_response2, true);
 
        $api_answer2 = $api_response2["choices"][0]["message"]["content"];
        echo '<div style="background-color: #FFFFE0; padding: 5px; margin-bottom: 10px;">';
        echo "<b> الاجابة:</b> " . highlightText($api_answer2, $question2) . "<br>";
        echo '</div>';
    }
}
 
function highlightText($text, $highlight) {
    // Case-insensitive highlight
    $text = preg_replace("/($highlight)/i", '<span style="background-color: #FFFF00;">$1</span>', $text);
    return $text;
}
?>	

<hr>



	
									
									
</center>

						</div>
					</div>  
					</div>		
				</div> 	
				
               
                <!-- /. ROW  -->

	   
		
		
			
				
				
				
				
               
                <!-- /. ROW  -->
				<footer><center><p>دلالات Dlalat  © 2023. جميع الحقوق محفوظة </p></center></footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
	 
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
	
	
	<script src="assets/js/easypiechart.js"></script>
	<script src="assets/js/easypiechart-data.js"></script>
	
	
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


</body>

</html>