<?php
require __DIR__ . '/vendor/Parsedown.php';
require __DIR__ . '/vendor/ParsedownExtra.php';

$Parsedown = new ParsedownExtra();

$md = <<<MD
# Heading 1
## Heading 2
**Bold text**
*Italic text*
- List item 1
- List item 2
MD;

echo $Parsedown->text($md);
