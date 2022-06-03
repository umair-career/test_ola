<?php
 function DBConnection($dbname)
 {
     if( env('APP_ENV') ==  'local' )
   {   $databse_name = $dbname;
       $host = '127.0.0.1';
       $user="root";
      $password="";
   }
    else
  {
    $databse_name = 'tic_tac';
    $host = 'localhost';
    $user="root";
    $password="";
  }
    $state = true;
   try {
      \Config::set('database.connections.myConnection', array(
        'driver'    => 'mysql',
        'host'      => $host,
        'database'  => $databse_name,
        'username'  => $user,
        'password'  => $password,
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        'strict' => false,
     ));
     \DB::setDefaultConnection('myConnection');
      $state = \DB::connection()->getPdo();

     \Config::set('database.connections.myConnection.database', $databse_name);
     \DB::setDefaultConnection('myConnection');
      \DB::reconnect('myConnection');

   } catch( \Exception $e) {
      $state = false;
   }
 return $state;
}
?>