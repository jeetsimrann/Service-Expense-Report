<div class="card mt-2" style="position: relative;">
                  <div class="card-header btn btn-link collapsed expandform" id="taskhead`+indexhours+`" data-toggle="collapse" data-target="#task`+indexhours+`" aria-expanded="false" aria-controls="task`+indexhours+`" style="text-align: left; font-weight:500; color: #000000; text-decoration:none;">
                  <span id="taskheadmain`+indexhours+`" name="taskheadmain[]"> Task Line </span>
                        <span style="color:grey;font-weight:light;font-size:0.8rem;" id="taskheadtag`+indexhours+`" name="taskheadtag[]" >                           
                        </span>  
                  </div>
                  <span class="btn btn-danger remove-btn-taskline w-25" style="position: absolute; left: 75%;"> Delete</span>
                  <div id="task`+indexhours+`" class="collapse" aria-labelledby="taskhead`+indexhours+`" data-parent="#task-accordion">
                      <div class="card-body">
                          
                            <div class="card-body">
                                <input type="hidden" class="form-control" id="taskID" name="taskID[]"/>
                                <div class="form-group mb-3 inputfield">
                                    <label for="tasktype">Task Type</label>
                                    <select name="tasktype[]" id="tasktype" class="custom-select form-control tasktype`+indexhours+`" onchange="$('#taskheadmain`+indexhours+`').text($('option:selected',this).text());">
                                    <option selected value="0"> Choose Task Type</option>
                                    <?php
                                        include "dbconnect.php";
                                        $sql = "SELECT * FROM dbo.tblServiceTasks";
                                        $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");
                                        while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                                        echo '<option value="'.$data['TaskID'].'">';
                                        echo $data['TaskName']; 
                                        echo "</option>";
                                    }
                                    ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3 inputfield">
                                    <label for="taskhours">Hours</label>
                                    <input type=number min="0" inputmode="decimal" step=".01" pattern="[0-9]*" ng-model="vm.decimalNumbers"  class="form-control" id="taskhours" name="taskhours[]" placeholder="Enter Hours" onchange="$('#taskheadtag`+indexhours+`').text(parseFloat($(this).val()).toFixed(2) + ' hrs');"/>
                                </div>

                                <div class="form-group mb-3 inputfield">
                                    <label for="tasknotes">Notes</label>
                                    <textarea type="text" class="form-control" id="tasknotes" name="tasknotes[]" rows="3"></textarea>
                                </div>
                            </div>



                            <div class="btn btn-danger collapsed" data-toggle="collapse" data-target="#task`+indexhours+`" aria-controls="task`+indexhours+`">
                              Close
                            </div> 
                      </div> 
                  </div>
              </div>