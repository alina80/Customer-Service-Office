<?php

require __DIR__ . '/../src/Template.php';

//Add code here

$index = new Template(__DIR__ . '/../templates/index.tpl');

$content = new Template(__DIR__ . '/../templates/client_content.tpl');

$index->add('content', $content->parse());

echo $index->parse();
