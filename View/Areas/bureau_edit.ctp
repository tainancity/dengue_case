<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'bureau_edit', $education['Education']['id'])));
    ?>
    <div class="Areas form">
        <h1>區公所填報</h1>
        <div class="row">
            <div class="col">日期： <?php echo $education['Education']['the_date']; ?></div>
            <div class="col">地區： <?php echo $education['Area']['name']; ?></div>
        </div>
        <hr />
        <?php
        echo $this->Form->input('Education.education', array(
            'value' => $education['Education']['education'],
            'label' => '宣導人次',
            'type' => 'number',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
    </div>
    <h2>區公所社區監測組孳生源清除</h2>
    <div id="formSourceContainer" class="form-inline">
        <?php foreach($areaSources AS $areaSource) { ?>
        <div class="alert alert-dark cunli-block" role="alert">
            <input type="hidden" name="AreaSource[id][]" value="<?php echo $areaSource['AreaSource']['id']; ?>">
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">里別</div>
                </div>
                <select class="form-control select-cunli" name="AreaSource[area_id][]"><?php
                    foreach($cunlis AS $cunliId => $cunliName) {
                        if($areaSource['AreaSource']['area_id'] != $cunliId) {
                            echo '<option value="' . $cunliId . '">' . $cunliName . '</option>';
                        } else {
                            echo '<option value="' . $cunliId . '" selected="selected">' . $cunliName . '</option>';
                        }
                    }
                    ?></select>
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">調查戶數</div>
                </div>
                <input type="number" class="form-control" name="AreaSource[investigate][]" value="<?php echo $areaSource['AreaSource']['investigate']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-right" style="width: 10%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">刪除</div>
                </div>
                <input type="checkbox" class="form-check-input field-delete" name="AreaSource[delete][]" value="<?php echo $areaSource['AreaSource']['id']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶內積水容器</div>
                </div>
                <input type="number" class="form-control" name="AreaSource[i_water][]" value="<?php echo $areaSource['AreaSource']['i_water']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶內陽性容器</div>
                </div>
                <input type="number" class="form-control" name="AreaSource[i_positive][]" value="<?php echo $areaSource['AreaSource']['i_positive']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶外積水容器</div>
                </div>
                <input type="number" class="form-control" name="AreaSource[o_water][]" value="<?php echo $areaSource['AreaSource']['o_water']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶外陽性容器</div>
                </div>
                <input type="number" class="form-control" name="AreaSource[o_positive][]" value="<?php echo $areaSource['AreaSource']['o_positive']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">已處理陽性數</div>
                </div>
                <input type="number" class="form-control" name="AreaSource[positive_done][]" value="<?php echo $areaSource['AreaSource']['positive_done']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">動員人數</div>
                </div>
                <input type="number" class="form-control" name="AreaSource[people][]" value="<?php echo $areaSource['AreaSource']['people']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 100%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">備註</div>
                </div>
                <input type="text" class="form-control field-note" name="AreaSource[note][]" value="<?php echo $areaSource['AreaSource']['note']; ?>">
            </div>
        </div>
        <?php } ?>
    </div>
    <a href="#" class="btn btn-success float-right" id="btn-source-cunli">新增一個里</a>
    <div class="clearfix"></div>
    <hr />
    <h2>防疫志工隊孳生源清除</h2>
    <div id="formVolunteerContainer" class="form-inline">
        <?php foreach($volunteerSources AS $volunteerSource) { ?>
        <div class="alert alert-dark cunli-block" role="alert">
            <input type="hidden" name="VolunteerSource[id][]" value="<?php echo $volunteerSource['VolunteerSource']['id']; ?>">
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">里別</div>
                </div>
                <select class="form-control select-cunli" name="VolunteerSource[area_id][]"><?php
                    foreach($cunlis AS $cunliId => $cunliName) {
                        if($volunteerSource['VolunteerSource']['area_id'] != $cunliId) {
                            echo '<option value="' . $cunliId . '">' . $cunliName . '</option>';
                        } else {
                            echo '<option value="' . $cunliId . '" selected="selected">' . $cunliName . '</option>';
                        }
                    }
                    ?></select>
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">調查戶數</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[investigate][]" value="<?php echo $volunteerSource['VolunteerSource']['investigate']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-right" style="width: 10%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">刪除</div>
                </div>
                <input type="checkbox" class="form-check-input field-delete" name="VolunteerSource[delete][]" value="<?php echo $volunteerSource['VolunteerSource']['id']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶內積水容器</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[i_water][]" value="<?php echo $volunteerSource['VolunteerSource']['i_water']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶內陽性容器</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[i_positive][]" value="<?php echo $volunteerSource['VolunteerSource']['i_positive']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶外積水容器</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[o_water][]" value="<?php echo $volunteerSource['VolunteerSource']['o_water']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶外陽性容器</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[o_positive][]" value="<?php echo $volunteerSource['VolunteerSource']['o_positive']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">已處理陽性數</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[positive_done][]" value="<?php echo $volunteerSource['VolunteerSource']['positive_done']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">志工人數</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[people][]" value="<?php echo $volunteerSource['VolunteerSource']['people']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 100%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">備註</div>
                </div>
                <input type="text" class="form-control field-note" name="VolunteerSource[note][]" value="<?php echo $volunteerSource['VolunteerSource']['note']; ?>">
            </div>
        </div>
        <?php } ?>
    </div>
    <a href="#" class="btn btn-success float-right" id="btn-volunteer-cunli">新增一個里</a>
    <input type="submit" class="btn btn-block btn-primary" value="送出" />
    <?php
    echo $this->Form->end();
    ?>
</div>
<?php
echo $this->Html->script('c/areas/bureau_edit.js');