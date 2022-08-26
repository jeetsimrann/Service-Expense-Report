<!-- html code to add new expense lines -->

<div class="card-body">
    
    <div class="form-group mb-3">
        <label for="exptype">Expense Type</label>
        <select name="exptype[]" id="exptype" class="custom-select form-control exptype`+index+`" onchange="$('#expheadmain`+index+`').text($('option:selected',this).text());">
        <option selected value="0"> Choose Expense Type</option>
        <?php
            include "dbconnect.php";
            $sql = "SELECT * FROM dbo.tblServiceExpenses";
            $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");
            while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                echo '<option value="'.$data['ExpenseID'].'">';
                echo $data['ExpenseType']; 
                echo "</option>";
            }
        ?>
        </select>
    </div>

    <div class="form-group mb-3  ">
        <label for="expamount">Amount</label>
        <input type=number min="0" inputmode="decimal" pattern="[0-9]*" step=".01" ng-model="vm.decimalNumbers"  class="form-control" id="expamount" name="expamount[]" placeholder="Enter Amount" onchange="$('#expheadtag`+index+`').text('$' + parseFloat($(this).val()).toFixed(2));"/>
    </div>

    <div class="form-group mb-3  ">
        <label for="expcurr">Currency</label>
        <select name="expcurr[]" id="expcurr" class="custom-select form-control"><option selected value="0"> Choose Currency</option>
        <?php
            $sql1 = "SELECT * FROM dbo.tblCurrency";
            $result = sqlsrv_query($conn,$sql1) or die("Couldn't execut query");
            while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                echo '<option value="'.$data['CurrID'].'">';
                echo $data['CurrCode']; 
                echo "</option>";
                $i++;
            }
        ?>
        </select>
    </div>

    <div class="form-group pt-1 mb-2">
        <div class="form-check form-check-inline">
            <input class="chkBox form-check-input" onchange="if($(this).is(':checked')){$(this).parent().find('.hidVal').prop('disabled',true);}else{$(this).parent().find('.hidVal').prop('disabled', false);}" type="checkbox" name="check1[]" value="1" />
            <input type="hidden" class="hidVal form-check-input" name="check1[]" value="0"/>
            <label class="form-check-label" for="check1">AFA CC</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="chkBox form-check-input check2true`+index+`" onchange="if($(this).is(':checked')){$(this).parent().find('.hidVal').prop('disabled',true);}else{$(this).parent().find('.hidVal').prop('disabled', false);}" type="checkbox" name="check2[]" value="1" />
            <input type="hidden" class="hidVal form-check-input check2false`+index+`" name="check2[]" value="0"/>
            <label class="form-check-label" for="check2">Receipt</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="chkBox form-check-input" onchange="if($(this).is(':checked')){$(this).parent().find('.hidVal').prop('disabled',true);}else{$(this).parent().find('.hidVal').prop('disabled', false);}" type="checkbox" name="check3[]" value="1" />
            <input type="hidden" class="hidVal form-check-input" name="check3[]" value="0"/>
            <label class="form-check-label" for="check3">Billable</label>
        </div>
    </div>

    <div class="form-group mb-3  ">
        <label for="expnotes">Notes</label>
        <textarea type="text" class="form-control" id="expnotes" name="expnotes[]" rows="3"></textarea>
    </div>

    <div class="form-group mb-3  ">
        <label for="file">Scan Receipt</label>
        <input type="file" class="form-control file`+index+`"id="file[]" name="file[]" 
                onchange="document.getElementById('img_url`+index+`').src  = window.URL.createObjectURL(this.files[0]);
                          document.getElementById('img-preview`+index+`').href  = window.URL.createObjectURL(this.files[0]);
                          $('#img-card`+index+`').css('display','block');
                          $('.check2true`+index+`').attr('checked', 'checked' );
                          $('.check2false`+index+`').prop('disabled','true');" 
                accept="image/*"/>
        <br>
        <div class="card img-card" id="img-card`+index+`" name="img-card[]" style="display:none">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="p-2">
                        <img src="" class="img_url" id="img_url`+index+`" name= "img_url[]" alt="your image" 
                          onchange="$('#img_u`+index+`').attr('src', $(this).attr('src'));" >
                    </div>
                    <div class="p-2">
                        <div class="d-flex flex-column">
                            <div class="p-2">   
                                <a href="" id="img-preview`+index+`" name= "img-preview[]" data-lightbox="image`+index+`" data-title="Scanned Receipt">Preview</a>
                            </div>
                            <div class="p-2">
                                <a name="rem" href="#" class="removeImg"
                                    onclick="event.preventDefault();
                                        $('#img-card`+index+`').css('display','none');
                                        $('.file`+index+`').val(null);$('#img_url`+index+`').removeAttr('src');
                                        $('.check2true`+index+`').removeAttr('checked');
                                        $('.check2false`+index+`').removeAttr('disabled');">
                                        Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>