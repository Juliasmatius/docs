<DOCTYPE !html>
<html>
  <head>
    <style>
      body {
          background-color: rgb(0, 27, 41);
          color: rgb(255, 255, 255);
          font-family: "Roboto Mono", monospace
      }
      a {
          color: rgb(255,255,255);
      }
      .main {
        position:absolute;
        top:10%;
        left:50%;
        transform: translate(-50%,-50%);
        text-align:center;
      }

      .footer {
        display: flex;
        position: absolute;
        left: 50%;
        bottom: 2%;
        margin-top: 200px;
        transform: translateX(-50%);
        text-align: center;
        max-width: 100%
      }
      .footer_text {
        position: relative;
        bottom: 50px;
        width: 100%
      }
      .footer_text p {
        margin: 0;
        text-align: center
      }
      .footer_images {
        display: flex;
        justify-content: center;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        max-width: 100%;
        min-width: 15%
      }
      .footer_images img {
        margin: 0 5px
      }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="twitter:site" content="https://julimiro.eu" />
    <meta name="twitter:title" content="Juli's docs page" />
  </head>

  <body>
    <div class="main">
  <?php 
if (!isset($_GET['id'])) {
  $info["contents"] = "";  
  $info["title"] = "Main page";
  $files = scandir("datafiles/");

  // Initialize the variable to store contents

  // Loop through each file
  foreach ($files as $file) {
      // Check if the file is a JSON file
      if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
          // Load the JSON data from the file
          $json = json_decode(file_get_contents("datafiles/" . $file), true);

          // Extract the ID from the file name
          $id = pathinfo($file, PATHINFO_FILENAME);

          // Append the link to the contents
          $info["contents"] .= '<a href="/?id=' . $id . '">' . $json["title"] . "</a><br>";
      }
    
  }
} else {
$json_data = file_get_contents("datafiles/".$_GET['id'].".json");
if ($json_data === false) {
  $info["contents"] = "Failed to read JSON file";
  $info["title"] = "Failed to read JSON file";
}
$info = json_decode($json_data, true);
if ($info === null) {
  $info["contents"] = "Failed to decode JSON data";
  $info["title"] = "Failed to decode JSON data";
}
if (!is_array($info)) {
  $info["contents"] = "Error: Unexpected data format";
  $info["title"] = "Error: Unexpected data format";
}
}

if ($info["contents"] == "" ){
  $info["contents"] = "Nothing to display.";
}

require "Parsedown.php";
$Parsedown = new Parsedown();

?>
      <title>
        <?php echo "Juli's docs - ".$info['title']; ?>
      </title>
      <h1>
        <?php echo $info['title']; ?>
      </h1>
      <?php echo $Parsedown->text($info['contents']); ?>
    </div>
  <div class="footer">
    <div class="footer_text"
      <p>&copy; <?php echo date(
        "Y"
    ); ?> <a href="https://julimiro.eu">Juli</a>. All rights reserved.</p>
  </div>
  </div>

</body>
</html>
