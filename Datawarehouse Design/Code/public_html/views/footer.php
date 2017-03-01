
<br><br>    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
  
    <script type="text/javascript">
        
       $("#querySubmit").click(function(){
           $('#querySubmit').prop('disabled', true);
//           alert($("#customQuery").val());
           $.ajax({
                type: "POST",
                url: "actions.php?action=customQuery",
                data: "query=" + $("#customQuery").val(),
                success: function(result) {
//                    alert(result);
                    $("#queryTable").html(result);
                    $('#querySubmit').prop('disabled', false);
                },
//               failure: function() {
//                    $('#querySubmit').prop('disabled', false);
//                }
            });
           
           
       });
        
        $("#op1Submit").click(function() {
            
            $.ajax({
                type: "POST",
                url: "queries.php?op=1",
                data: "disease=" + $("#op1dType").val() +"&name="+ $("#op1dName").val(),
                success: function(result) {
                    $("#customQuery").val(result);
                    $("#querySubmit").click();
                    //$("#queryTable").html(result);
                }
            });
        });
        $("#op2Submit").click(function() {
            
            $.ajax({
                type: "POST",
                url: "queries.php?op=2",
                data: "disease=" + $("#op2dType").val() +"&name="+ $("#op2dName").val(),
                success: function(result) {
                    $("#customQuery").val(result);
                    $("#querySubmit").click();
                    
                }
            });
        });
        
        $("#op3Submit").click(function() {
            
            $.ajax({
                type: "POST",
                url: "queries.php?op=3",
                data: "name=" + $("#op3Name").val() +"&cluster="+ $("#op3Cluster").val()+"&muid="+ $("#op3muId").val(),
                success: function(result) {
                    $("#customQuery").val(result);
                    $("#querySubmit").click();
                    
                }
            });
        });
        
        $("#op4Submit").click(function() {
//            $("#testResult").html("");
            $.ajax({
                dataType: "json",
                type: "POST",
                url: "tstat.php?goid="+ $("#op4goId").val()+"&name="+ $("#op4Name").val(),
                success: function(result) {
                    $("#query1").html("<strong>QUERY 1:</strong><br>"+result["query1"]);
                    $("#query2").html("<strong>QUERY 2:</strong><br>"+result["query2"]);
                    $("#resultT").html("<strong>RESULT:</strong><br>t = "+result["t"]+"<br>p(one tailed) = "+result["p1"]+"<br>p(two tailed) = "+result["p2"]);
                    
                }
            });
        });
        
        $("#op5Submit").click(function() {
            var urlv="fstat.php?";
            if($("#ALLCheck").is(':checked')){
                urlv+= "&ALL=1";
            }
            if($("#AMLCheck").is(':checked')){
                urlv+= "&AML=1";
            }
            if($("#ColonCheck").is(':checked')){
                urlv+= "&Colon=1";
            }
            if($("#BreastCheck").is(':checked')){
                urlv+= "&Breast=1";
            }
            if($("#FluCheck").is(':checked')){
                urlv+= "&Flu=1";
            }
            if(urlv == "fstat.php?"){
                alert("Please select atleast 2 diseases");
            }
            $.ajax({
                dataType: "json",
                type: "POST",
                url: urlv,
                success: function(result) {
                    console.log(result);
                    $("#query1F").html("<strong>QUERY 1:</strong><br>"+result["query"]);
                    $("#query2F").html("<strong>QUERY 2 (Run for each selected disease):</strong><br>"+result["query2"]);
                    $("#resultF").html("<strong>RESULT:</strong><br>SSd = "+result["SSd"]+", SSe = "+result["SSe"]+"<br>MSd = "+result["MSd"]+", MSe = "+result["MSe"]+"<br>F = "+result["F"]+"<br>p = "+result["p"]);
                }
            });            
            
        });
        
        $("#op6Submit1").click(function() {
            var urlv = "lastquery.php?goid=" + $("#op6goId1").val() +"&name="+ $("#op6Name1").val();
            $.ajax({
                dataType: "json",
                type: "POST",
                url: urlv,
                success: function(result) {
                    $("#query1C").html("<strong>QUERY 1:</strong><br>"+result["query1"]);
                    $("#query2C").html("<strong>QUERY 2 (Run for each patient with disease):</strong><br>"+result["query2"]);
                    $("#resultC").html("<strong>RESULT:</strong><br>Sum of all possible correlations = "+result["result1"]+"<br>Count of N1 X (N1 - 1) /2 = "+result["result2"]+"<br>Average Correlation = "+result["result3"]);
                }
            });
        });
        
        $("#op6Submit2").click(function() {
            var urlv = "LQtest2.php?goid=" + $("#op6goId2").val() +"&name1="+ $("#op6Name2a").val() +"&name2="+ $("#op6Name2b").val();
            
            $.ajax({
                dataType: "json",
                type: "POST",
                url: urlv,
                success: function(result) {
                    $("#query1C").html("<strong>QUERY 1:</strong><br>"+result["query1"]+"<br><strong>QUERY 1b(for each patient with disease):</strong>"+result["query2"]);
                    $("#query2C").html("<strong>QUERY 2:</strong><br>"+result["query3"]+"<br><strong>QUERY 2b(for each patient with disease):</strong>"+result["query4"]);
                    $("#resultC").html("<strong>RESULT:</strong><br>Sum of all possible correlations = "+result["result1"]+"<br>Count of N1 X N2 = "+result["result2"]+"<br>Average Correlation = "+result["result3"]);
                }
            });
        });
        
        $("#op_part_3_1_Submit").click(function() {
        console.log("here");
            var urlv = "part3_ui.php?name="+ $("#op_part3_1_dName").val()+"&p_limit="+$("#op_part3_1_p_limit").val();
            console.log(urlv);
            $.ajax({
                dataType: "json",
                type: "POST",
                url: urlv,
                success: function(result) {
                    console.log("success");
                    console.log(result);
                    $("#query1").html("<strong>QUERY 1:</strong><br>"+result["query1"]);
                    $("#query2").html("<strong>QUERY 2 (Run for each patient with disease):</strong><br>"+result["query2"]);
                    $("#no_of_rows1").html("<strong>No of Informative genes: </strong><br>"+result["noofrows"]);
                    $("#informative_genes").html("<strong>Informative genes list: </strong><br>"+result["result"]);
                    //$("#resultC").html("<strong>RESULT:</strong><br>Sum of all possible correlations = "+result["result1"]+"<br>Count of N1 X (N1 - 1) /2 = "+result["result2"]+"<br>Average Correlation = "+result["result3"]);
                }
            });
        });
        
        $("#op_part_3_2_a_Submit").click(function() {
        console.log("here");
            var urlv = "part3-2_a_ui.php?name="+ $("#op_part3_1_dName").val();
            console.log(urlv);
            $.ajax({
                dataType: "json",
                type: "POST",
                url: urlv,
                success: function(result) {
                    console.log("success");
                    console.log(result);
                    $("#no_of_rows2").html("<strong>no of rows: </strong><br>"+result["noofrows"]);
                    $("#ra_values").html("<strong>rA values list: </strong><br>"+result["result"]);
                    //$("#resultC").html("<strong>RESULT:</strong><br>Sum of all possible correlations = "+result["result1"]+"<br>Count of N1 X (N1 - 1) /2 = "+result["result2"]+"<br>Average Correlation = "+result["result3"]);
                },
                        error: function(){
    console.log('failure');
  }
            });
        });
        
        $("#op_part_3_2_b_Submit").click(function() {
        console.log("here");
            var urlv = "part3-2_b_ui.php?name="+ $("#op_part3_1_dName").val();
            console.log(urlv);
            $.ajax({
                dataType: "json",
                type: "POST",
                url: urlv,
                success: function(result) {
                    console.log("success");
                    console.log(result);
                    $("#no_of_rows3").html("<strong>no of rows: </strong><br>"+result["noofrows"]);
                    $("#rb_values").html("<strong>rA values list: </strong><br>"+result["result"]);
                    //$("#resultC").html("<strong>RESULT:</strong><br>Sum of all possible correlations = "+result["result1"]+"<br>Count of N1 X (N1 - 1) /2 = "+result["result2"]+"<br>Average Correlation = "+result["result3"]);
                },
                        error: function(){
    console.log('failure');
  }
            });
        });
        
        $("#op_part_3_end_Submit").click(function() {
        console.log("here");
            var urlv = "part3-2_b_end_ui.php?name="+ $("#op_part3_1_dName").val();
            console.log(urlv);
            $.ajax({
                dataType: "json",
                type: "POST",
                url: urlv,
                success: function(result) {
                    console.log("success");
                    console.log(result);
                    $("#no_of_rows4").html("<strong>no of rows: </strong><br>"+result["noofrows"]);
                    $("#classification_values").html("<strong>Classification result: </strong><br>"+result["result"]);
                    //$("#resultC").html("<strong>RESULT:</strong><br>Sum of all possible correlations = "+result["result1"]+"<br>Count of N1 X (N1 - 1) /2 = "+result["result2"]+"<br>Average Correlation = "+result["result3"]);
                },
                        error: function(){
    console.log('failure');
  }
            });
        });
        
</script>


</body>
</html>