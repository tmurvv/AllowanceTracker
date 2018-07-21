<?php

//Create Selector Queries
  $query = "SELECT * FROM categories ORDER BY categoryViewOrder";
  //Run Query
  $categories = $db->select($query);

  //Create Job Type Query 
  $query = "SELECT * FROM jobtypes ORDER BY jobTypeViewOrder"; 
  //Run Query 
  $jobtypes = $db->select($query); 

  //Create Location Query 
  $query = "SELECT * FROM locations Order BY locationViewOrder"; 
  //Run Query 
  $locations = $db->select($query);

  ?>