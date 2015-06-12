<?php
  // Usage: http://10.1.94.128:8000/~rgirdhar/memex/demos/0001_SegService/index.php?url=http://10.1.94.128:8000/~rgirdhar/memex/dataset/0001_Backpage/Images/ImagesTexas/Texas_2012_10_10_1349841918000_4_0.jpg
  //$url = 'https://cmu.memexproxy.com/segment';
  $url = 'http://localhost:8888/segment';
  $data = $_GET["url"];

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

  $imsize = getimagesize($data);
  echo '<table><tr>';
  echo '<td><img src="' . $data . '" /></td>';
  echo "<td><img style='display:block; width:" . $imsize[0] . "px; height:" . $imsize[1] . "px;' id='seg' src='data:image/jpeg;base64, " . $result[0][1] . "' /></td>";
  echo '</tr></table>';
?>
