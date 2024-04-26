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
        top:15%;
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
      .logo {
        width:auto;
        height: 50px;
      }
      .logo img {
        position: absolute;
        transform: translate(-50%,-50%);
        top: 15%;
        width:auto;
        height:50px;
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

  foreach ($files as $file) {
      if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
          $json = json_decode(file_get_contents("datafiles/" . $file), true);
          $id = pathinfo($file, PATHINFO_FILENAME);
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
      <div class="logo">
        <img src="/static/logo-white-transparent.svg">
      </div>
      <h1>
        <?php echo $info['title']; ?>
      </h1>
      <?php echo $Parsedown->text($info['contents']); ?>
      <br><br>
    </div>
  <div class="footer">
    <div class="footer_text">

      <a href="/">Back to home</a>
      <p>&copy; <?php echo date(
        "Y"
    ); ?> <a href="https://julimiro.eu">Juli</a>. All rights reserved.</p>
  </div>
  </div>

</body>
</html>
