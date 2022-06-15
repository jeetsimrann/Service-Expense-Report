<div class="card-body">
    <div class="form-group mb-3 inputfield">
        <label for="tasktype">Task Type</label>
        <select name="tasktype[]" id="tasktype" class="custom-select form-control" onchange="$('#taskheadmain`+indexhours+`').text($('option:selected',this).text());">
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
        <input type=number min="0" inputmode="decimal" pattern="[0-9]*" step=".01" ng-model="vm.decimalNumbers"  class="form-control taskhour-validation" id="taskhours" name="taskhours[]" placeholder="Enter Hours" onchange="$('#taskheadtag`+indexhours+`').text(parseFloat($(this).val()).toFixed(2) + ' hrs');"/>
    </div>    
                        

    <div class="form-group mb-3 inputfield">
        <label for="tasknotes">Notes</label>
        <textarea type="text" class="form-control" id="tasknotes" name="tasknotes[]" rows="3"></textarea>
    </div>
</div>