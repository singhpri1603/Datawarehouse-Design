<?php

?>
<html>
<head>
    </head>
    <body>
    
    <script type="text/javascript">
        var ttest = require('ttest');
 
// One sample t-test 
ttest([0,1,1,1], {mu: 1}).valid() // true 
 
// Two sample t-test 
ttest([0,1,1,1], [1,2,2,2], {mu: -1}).valid() // true 
alert(stat.pValue());
        </script>
    </body>
</html>