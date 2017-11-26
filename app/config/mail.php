<?php

return array(
 
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'from' => array('address' => 'explorefusionmate@gmail.com', 'name' => 'fusionmate'),
    'encryption' => 'tls',
    'username' => 'explorefusionmate@gmail.com',
    'password' => 'Explore@123',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
 
);
