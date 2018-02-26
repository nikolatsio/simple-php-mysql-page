<html>
<head>
   <title>PHP and MySQL test repo</title>
</head>
<body>
   <img src="logo.png" />
   <br>
   <h1>Demo: PHP, MySQL and OpenShift</h1>

<?php
   $database = "sampledb";
   $user = "testadm";
   $password  = "r1r2r3";
   $host = "mysql-55-centos7-2";

   try {
      $connection = new PDO("mysql:host={$host};dbname={$database};charset=utf8", $user, $password);
      $query = $connection->query("SELECT dc.command_category, dc.command_name, dc.command_description, de.example_code, de.example_description FROM docker_commands dc LEFT JOIN docker_examples de ON dc.command_id = de.command_id ORDER BY dc.command_id, de.example_id");
      $commands = $query->fetchAll();

      if (empty($commands)) {
         echo "<h3>There is no information in the database</h3>\n";
      } else {
         $last_category="";
         $last_command="";
         //
         foreach ($commands as $command) {
            print "<div>\n";
            if ($last_category <> $command['command_category'])
               print "<h2>{$command['command_category']}</h2>\n";
            //
            if ($last_command <> $command['command_name']) {
               print "<hr>\n";
               print "<h3>docker {$command['command_category']} {$command['command_name']}</h3>\n";
               print "<h3><i>{$command['command_description']}</i></h3>\n";
            }
            //
            print "<h4>EXAMPLE: {$command['example_code']}</h4>\n";
            print "<h4>DESCRIPTION: {$command['example_description']}</h4>\n";
            print "</div>\n";
            print "<br />\n";
            //
            $last_category = $command['command_category'];
            $last_command = $command['command_name'];
         }
      }
   }
   catch (PDOException $e) {
      print "<h3>There is no database available. Try again later.</h3>\n";
      print "<h3>Meanwhile you can check <a href=\"https://docs.docker.com/\">here</a> for more information.\n";
   }
?>
   
   <br />
   <br />
   <hr />
   <h3>Nikolay Nikolov :)</h3>

</body>
</html>
