<div class="card-body">
    <input type="hidden" class="form-control" id="taskID" name="taskID[]"/>
    <div class="form-group mb-3 inputfield">
        <label for="tasktype">Task Type</label>
        <select name="tasktype[]" id="tasktype" class="custom-select form-control" onchange="$('#taskheadtag`+indexhours+`').text($('option:selected',this).text());" required><option selected> Choose Task Type</option>
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
        <input type=number min="0" inputmode="decimal" pattern="[0-9]*" ng-model="vm.decimalNumbers"  class="form-control taskhour-validation" id="taskhours" name="taskhours[]" placeholder="Enter Hours" required/>
    </div>

    <div class="form-group mb-3 inputfield">
        <label for="tasknotes">Notes</label>
        <textarea type="text" class="form-control" id="tasknotes" name="tasknotes[]" rows="3"></textarea>
    </div>
</div>