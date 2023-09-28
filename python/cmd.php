<?php
$command = 'python3 main.py 2>&1'; // Capture both standard output and error
$output = exec($command);

echo $output;