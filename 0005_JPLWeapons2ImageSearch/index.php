<?php
  // Usage: http://10.1.94.128:8000/~rgirdhar/memex/demos/0001_SegService/index.php?url=http://10.1.94.128:8000/~rgirdhar/memex/dataset/0001_Backpage/Images/ImagesTexas/Texas_2012_10_10_1349841918000_4_0.jpg
  //$url = 'https://cmu.memexproxy.com/segment';
  $data = $_GET["url"];
  $method = $_GET["method"];
  if (strcmp($method, "full") == 0) {
    $url = 'http://localhost:8888/JPLWeapons2_fullImg';
  } else { // default
    $url = 'http://localhost:8888/JPLWeapons2_bgImg';
  }

  $options = array(
    'http' => array(
      'header'  =>  array(
        'Content-type: text',
        sprintf('Content-length: %d', strlen($data)),
        sprintf('Authorization: Basic %s', base64_encode('darpamemex:darpamemex')),
      ),
      'method'  =>  'POST',
      'content' =>  $data,
    ),
  );
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  $result = json_decode($result);

  echo "Query Image<br/>";
  echo '<img width="200px" src="' . $data . '" /><hr />';

  $elPerRow = 20;
  echo "<table><tr>";
  $cur_row = 0;
  for ($i = 0; $i < count($result); $i++) {
    echo '<td><img height="50px" src="' . $result[$i][0] . '" /><br/>' . $result[$i][1] . '<td>';
    $cur_row += 1;
    if ($cur_row >= $elPerRow) {
      $cur_row = 0;
      echo "</tr><tr>";
    }
  }
  echo "</tr></table>";
?>
