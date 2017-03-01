<div class="container">

<div id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          PART III: Patients with disease(group A)
        </a>
      </h5>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <form class="form-inline">
          <div class="form-group">
            <label for="op1dType">Find informative genes for Group A Patients who had disease name</label>
<!--            <select class="form-control" id="op1dType">
              <option>description</option>
              <option>type</option>
              <option>name</option>
              
            </select>-->
          </div>
          <div class="form-group">
            <label for="op_part3_1_dName">as</label>
            
              <input type="text" class="form-control" id="op_part3_1_dName"  value="ALL">
              <label for="op_part3_1_p_limit">p val limit</label>
                 <input type="text" class="form-control" id="op_part3_1_p_limit"  value="0.01">
              <a class="btn btn-outline-success btn-sm" role="button" id="op_part_3_1_Submit" href="#queryDiv">Execute</a>
          </div>
           
         
        </form>
        <div  id="testResult">
            <div class="row">
            <hr>
            <div class = "col-md-6" id="query1" style="font-size: 0.8em;"></div>
            <div class = "col-md-6" id="query2" style="font-size: 0.8em;"></div>
            </div>
            <div class="row">
            <hr>
            <div class = "col-md-6" id="no_of_rows1" style="font-size: 0.8em;"></div>
            <div class = "col-md-6" id="informative_genes" style="font-size: 0.8em;"></div>
            </div>
            <div class="row"><div class="col-md-12 alert alert-success" id="resultT"></div></div>

        </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Values of rA for Group A
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        
        <form class="form-inline">
          
          <div class="form-group">
            
              <a class="btn btn-outline-success btn-sm" role="button"  id="op_part_3_2_a_Submit" href="#queryDiv">Execute</a>
          </div>
           
         
        </form>
        <div  id="testResult2">            
            <div class="row">
            <hr>
            <div class = "col-md-6" id="no_of_rows2" style="font-size: 0.8em;"></div>
            
            </div>
            <div class = "row" id="ra_values" style="font-size: 0.8em;"></div>
            <div class="row"><div class="col-md-12 alert alert-success" id="resultT2"></div></div>

        </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Values of rB for Group B
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
<form class="form-inline">
          
          <div class="form-group">
            
              <a class="btn btn-outline-success btn-sm" role="button"  id="op_part_3_2_b_Submit" href="#queryDiv">Execute</a>
          </div>
           
         
        </form>
        <div  id="testResult3">            
            <div class="row">
            <hr>
            <div class = "col-md-6" id="no_of_rows3" style="font-size: 0.8em;"></div>
<!--            <div class = "col-md-6" id="rb_values" style="font-size: 0.8em;"></div>-->
            </div>
            <div class = "row" id="rb_values" style="font-size: 0.8em;"></div>
            <div class="row"><div class="col-md-12 alert alert-success" id="resultT3"></div></div>

        </div>
    </div> 
      
      
  </div>
    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingfour">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
          Final classification:
        </a>
      </h5>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
<form class="form-inline">
          
          <div class="form-group">
            
              <a class="btn btn-outline-success btn-sm" role="button"  id="op_part_3_end_Submit" href="#queryDiv">Execute</a>
          </div>
           
         
        </form>
        <div  id="testResult4">            
            <div class="row">
            <hr>
            <div class = "col-md-6" id="no_of_rows4" style="font-size: 0.8em;"></div>
            <div class = "col-md-6" id="classification_values" style="font-size: 0.8em;"></div>
            </div>
            <div class="row"><div class="col-md-12 alert alert-success" id="resultT4"></div></div>

        </div>
    </div> 
      
      
  </div>
    
    
    
    
</div>
    
    </div>