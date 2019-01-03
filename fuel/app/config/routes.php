<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	'v1/user' => array(array('POST', new Route('/v1/users/user'))),
	'v1/user?' => array(array('GET', new Route('/v1/users/user'))),
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);