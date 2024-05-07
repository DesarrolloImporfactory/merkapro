<?php
echo json_encode(exec('git rev-parse --abbrev-ref HEAD'));
