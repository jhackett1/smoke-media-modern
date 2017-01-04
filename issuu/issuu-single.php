<?php
get_header();


$url = "http://api.issuu.com/1_0?action=issuu.document_embeds.list&apiKey=" . get_option('issuu_api_key') . "&documentId=" . $issuu_id;

echo $url;

 ?>
