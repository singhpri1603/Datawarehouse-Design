<div class="container">

<div id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Operation 1: Patients with disease
        </a>
      </h5>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <form class="form-inline">
          <div class="form-group">
            <label for="op1dType">List the number of patients who had disease</label>
            <select class="form-control" id="op1dType">
              <option>description</option>
              <option>type</option>
              <option>name</option>
              
            </select>
          </div>
          <div class="form-group">
            <label for="op1dName">as</label>
            
              <input type="text" class="form-control" id="op1dName"  value="tumor">
              <a class="btn btn-outline-success btn-sm" role="button" id="op1Submit" href="#queryDiv">Execute</a>
          </div>
           
         
        </form>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Operation 2: Type of Drugs 
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        
        <form class="form-inline">
          <div class="form-group">
            <label for="op2dType">List the type of drugs which have been applied to patients with disease </label>
            <select class="form-control" id="op2dType">
              <option>description</option>
              <option>type</option>
              <option>name</option>
              
            </select>
          </div>
          <div class="form-group">
            <label for="op2dName">as</label>
            
              <input type="text" class="form-control" id="op2dName"  value="tumor">
              <a class="btn btn-outline-success btn-sm" role="button"  id="op2Submit" href="#queryDiv">Execute</a>
          </div>
           
         
        </form>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Operation 3: mRNA values
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
<!--       form begins -->
        <form class="form-inline">
          <div class="form-group">
            <label for="op3Name">For each sample of patients with</label>
            <input type="text" class="form-control" id="op3Name"  value="ALL">
            <label for="op3Cluster">, list the mRNA values (expression) of probes in cluster id</label>
              <input type="text" class="form-control" id="op3Cluster"  value="00002">
              <label for="op3muId">for each experiment with measure unit id =</label>
              <input type="text" class="form-control" id="op3muId"  value="001">
              <a class="btn btn-outline-success btn-sm" role="button"  id="op3Submit" href="#queryDiv">Execute</a>
          </div>  
        </form>
       
<!--form ends-->
    </div> 
      
      
  </div>
    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
          Operation 4: T-Statistics
        </a>
      </h5>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
<!--       form begins -->
        <form class="form-inline">
          <div class="form-group">
            <label for="op4goId">For probes belonging to GO with id=</label>
            <input type="text" class="form-control" id="op4goId"  value="0012502">
            <label for="op4Name">, calculate the t-statistcs for patients with </label>
              <input type="text" class="form-control" id="op4Name"  value="ALL"> <label>and patients without this disease.</label>
              <a class="btn btn-outline-success btn-sm" role="button"  id="op4Submit" href="#testResult">Execute</a>
          </div>  
        </form>
       
<!--form ends-->
        <div  id="testResult">
            <div class="row">
            <hr>
            <div class = "col-md-6" id="query1" style="font-size: 0.8em;"></div>
            <div class = "col-md-6" id="query2" style="font-size: 0.8em;"></div>
            </div>
            <div class="row"><div class="col-md-12 alert alert-success" id="resultT"></div></div>

        </div>
        
        </div>
    
    
    
    </div>
    
    
    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFive">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
          Operation 5: F-Statistics
        </a>
      </h5>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
<!--       form begins -->
        <form class="form-inline">
          <div class="form-group">
            <label for="op5goId">For probes belonging to GO with id=</label>
            <input type="text" class="form-control" id="op5goId"  value="0007154">
            <label for="op5Name">, calculate the f-statistcs for patients with </label>
              <label class="form-check">
                  <input class="form-check-input" type="checkbox" id="ALLCheck" value="option1"> ALL
                </label>
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" id="AMLCheck" value="option2"> AML
                </label>
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" id="ColonCheck" value="option4"> Colon Tumor
                </label>
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" id="BreastCheck" value="option5"> Breast Tumor
                </label>
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" id="FluCheck" value="option6"> Flu
                </label>
              <label>and patients without this disease.</label>
              <a class="btn btn-outline-success btn-sm" role="button"  id="op5Submit" href="#testResultF">Execute</a>
          </div>  
        </form>
       
<!--form ends-->
        <div  id="testResultF">
            <div class="row">
            <hr>
            <div class = "col-md-6" id="query1F" style="font-size: 0.8em;"></div>
            <div class = "col-md-6" id="query2F" style="font-size: 0.8em;"></div>
            </div>
            <div class="row"><div class="col-md-12 alert alert-success" id="resultF"></div></div>

        </div>
        
        </div>
    
    
    
    </div>
    
    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingSix">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
          Operation 6: Pearson's Correlation
        </a>
      </h5>
    </div>
    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
<!--       form begins -->
        <form class="form-inline">
          <div class="form-group">
            <label for="op6goId1"><h5>A: </h5>For probes belonging to GO with id=</label>
            <input type="text" class="form-control" id="op6goId1"  value="0007154">
            <label for="op6Name1">, calculate the average correlation for 2 patients with </label>
              <input type="text" class="form-control" id="op6Name1"  value="ALL">
              <a class="btn btn-outline-success btn-sm" role="button"  id="op6Submit1" href="#testResultC">Execute</a>
              <hr>
          </div>  
        </form>
       <form class="form-inline">
          <div class="form-group">
            <label for="op6goId2"><h5>B: </h5>For probes belonging to GO with id=</label>
            <input type="text" class="form-control" id="op6goId2"  value="0007154">
            <label for="op6Name2">, calculate the correlation for expression value of a patient with </label>
              <input type="text" class="form-control" id="op6Name2a"  value="ALL">
              <label for="op6Name2"> and a patient with </label>
              <input type="text" class="form-control" id="op6Name2b"  value="AML">
              <a class="btn btn-outline-success btn-sm" role="button"  id="op6Submit2" href="#testResultC">Execute</a>
          </div>  
        </form>
<!--form ends-->
        <div  id="testResultC">
            <div class="row">
            <hr>
            <div class = "col-md-6" id="query1C" style="font-size: 0.8em;"></div>
            <div class = "col-md-6" id="query2C" style="font-size: 0.8em;"></div>
            </div>
            <div class="row"><div class="col-md-12 alert alert-success" id="resultC"></div></div>

        </div>
        
        </div>
    
    
    
    </div>
    
</div>
    
    </div>