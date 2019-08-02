<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'volunteer_sources')));
    ?>
    <h1>防疫志工隊孳生源清除</h1>
        <?php
        echo $this->Form->input('VolunteerSource.the_date', array(
            'label' => '日期',
            'type' => 'text',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
    <div id="formContainer" class="form-inline">
        <div class="alert alert-dark cunli-block" role="alert">
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">區別</div>
                </div>
                <select class="form-control select-area" name="VolunteerSource[parent_id][]"><?php
                foreach($areas AS $k => $v) {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                }
                ?></select>
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">里別</div>
                </div>
                <select class="form-control select-cunli" name="VolunteerSource[area_id][]"></select>
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">調查戶數</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[investigate][]" value="0">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶內積水容器</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[i_water][]" value="0">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶內陽性容器</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[i_positive][]" value="0">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶外積水容器</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[o_water][]" value="0">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">戶外陽性容器</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[o_positive][]" value="0">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">已處理陽性數</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[positive_done][]" value="0">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">志工人數</div>
                </div>
                <input type="number" class="form-control" name="VolunteerSource[people][]" value="0">
            </div>
            <div class="input-group mb-2 mr-sm-2 float-left" style="width: 100%;">
                <div class="input-group-prepend">
                    <div class="input-group-text">備註</div>
                </div>
                <input type="text" class="form-control" name="VolunteerSource[note][]">
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-success float-right" id="btn-add-cunli">新增一個里</a>
    <input type="submit" class="btn btn-block btn-primary" value="送出" />
    <?php
    echo $this->Form->end();
    ?>
</div>
<?php
echo $this->Html->script('c/areas/volunteer_sources.js');
