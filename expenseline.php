<div class="card-body">
                       
                        <div class="form-group mb-3  ">
                            <label for="exptype">Expense Type</label>
                            <select name="exptype[]" id="exptype" class="custom-select form-control" onchange="$('#exphead`+index+`').text($('option:selected',this).text());"><option selected> Choose Expense Type</option>
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

                        <!-- <div class="form-group mb-3 inputfield">
                            <label for="exptype">Expense Type</label>
                            <input type="text" class="form-control" id="exptype" name="exptype" placeholder="Select Expense Type"/>
                        </div> -->
                        <div class="form-group mb-3  ">
                            <label for="expamount">Amount</label>
                            <input type="text" class="form-control" id="expamount" name="expamount[]" placeholder="Enter Amount"/>
                        </div>
                        <div class="form-group mb-3  ">
                            <label for="expcurr">Currency</label>
                            <!-- <input type="text" class="form-control" id="expcurr" name="expcurr" placeholder="Select Currency"/> -->
                            <select name="expcurr[]" id="expcurr" class="custom-select form-control"><option selected> Choose Currency</option>
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
                            <!-- <div class="form-check form-check-inline">
                                <input class="form-check-input" onChange="$(this).val(this.checked? 'true': 'false');" type="checkbox" name="check1[]" value="false" checked>
                                <label class="form-check-label" for="check1">AFA CC</label>
                            </div> -->
                            <div class="form-check form-check-inline">
                                <input class="chkBox form-check-input" onchange="if($(this).is(':checked')){$(this).parent().find('.hidVal').prop('disabled',true);}else{$(this).parent().find('.hidVal').prop('disabled', false);}" type="checkbox" name="check1[]" value="1" />
                                <input type="hidden" class="hidVal form-check-input" name="check1[]" value="0"/>
                                <label class="form-check-label" for="check1">AFA CC</label>
                            </div>
                            <!-- <div class="form-check form-check-inline">
                                <input class="form-check-input" onChange="$(this).val(this.checked? 'true': 'false');" type="checkbox" name="check2[]" value="false" checked>
                                <label class="form-check-label" for="check2">Receipt</label>
                            </div> -->
                            <div class="form-check form-check-inline">
                                <input class="chkBox form-check-input" onchange="if($(this).is(':checked')){$(this).parent().find('.hidVal').prop('disabled',true);}else{$(this).parent().find('.hidVal').prop('disabled', false);}" type="checkbox" name="check2[]" value="1" />
                                <input type="hidden" class="hidVal form-check-input" name="check2[]" value="0"/>
                                <label class="form-check-label" for="check2">Receipt</label>
                            </div>
                            <!-- <div class="form-check form-check-inline">
                                <input class="form-check-input" onChange="$(this).val(this.checked? 'true': 'false');" type="checkbox" name="check3[]" value="false" checked>
                                <label class="form-check-label" for="check3">Billable</label>
                            </div> -->
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
                            <input type="file" class="form-control" id="file[]" name="file[]" 
                                    onchange="document.getElementById('img_url`+index+`').src  = window.URL.createObjectURL(this.files[0]);
                                              document.getElementById('img-preview`+index+`').href  = window.URL.createObjectURL(this.files[0]);
                                              $('#img-card`+index+`').css('display','block');" 
                                    accept="image/*"/>
                            <br>
                             <!-- <img src="" class="img_url" id="img_url`+index+`" alt="your image" style="display:none;"> -->
                             
                             <div class="card img-card" id="img-card`+index+`" >
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="p-2">
                                            <img src="" class="img_url" id="img_url`+index+`" alt="your image" >
                                        </div>
                                        <div class="p-2">
                                            <div class="d-flex flex-column">
                                                <div class="p-2"><a href="" id="img-preview`+index+`" data-lightbox="image`+index+`" data-title="My caption">Preview</a></div>
                                                <div class="p-2"><a name="rem" href="#" onclick="event.preventDefault();$('#img-card`+index+`').css('display','none');">Remove</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <!-- <div class="form-group mb-3  ">
                            <label for="file">Scan Receipt</label>
                            <input type="file" class="form-control" id="file" name="file" />
                        </div>   -->
                    </div>