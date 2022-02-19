<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple web contact form</title>
</head>
<body>
    <h1>Simple web contact form</h1>
    <div class="content">
        <form action='index.php' method="post">
            <label for='name'>Name</label>
            <input name='name' type="text">
            <label for="mail">E-Mail</label>
            <input name='mail' type="email">
            <label for="dropdown">Issue</label>
            <select name='dropdown'>
                <option value="query">Query</option>
                <option value="feedback">Feedback</option>
                <option value="complaint">Complaint</option>
                <option value="other">Other</option>
            </select>
            <label for='comment'>Comment</label>
            <input name='comment' type="text">
            <input name='submit' type="submit">
        </form>
    </div>
    <script>

    </script>
</body>
</html>
<?php
if(isset($_POST['submit'])){
    $name = htmlspecialchars($_POST['name']);
    $mail = htmlspecialchars($_POST['mail']);
    $issue = htmlspecialchars($_POST['dropdown']);
    $message = htmlspecialchars($_POST['comment']);

    $input = [
        'name' => $name, 
        'mail' => $mail, 
        'issue' => $issue, 
        'comment' => $message
    ];

    $status = TRUE;
    $missingInput = [];
    foreach ($input as $key => $i){
        if(!isset($i) || empty($i)){
            $status = FALSE;
            $missingInput[] = $key;
        }
    }

    if ($status == TRUE){
        echo "<h1>Your message</h1>";
		echo "<h2> Name: </h2>  <p> ". $name ."</p>"; 
    	echo "<h2>E-Mail: </h2> <p> ". $mail ."</p>";
    	echo "<h2>Issue: </h2> <p> ". $issue ."</p>";
    	echo "<h2>Message: </h2> <p> ". $message ."</p>";
    }else{
        echo "<h1> Your Input cannot be empty </h1>";
        echo "<h2> Missing input </h2> <p> " . implode(', ', $missingInput) . " </p>";
    }
}
?>