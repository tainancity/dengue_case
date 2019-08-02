<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'clinic_reports')));
    ?>
    <div class="Areas form">
        <h1>醫療院所通報數</h1>
        <?php
        echo $this->Form->input('ClinicReport.the_date', array(
            'label' => '日期',
            'type' => 'text',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
        <div id="formContainer" class="form-inline">
            <div class="alert alert-dark area-block" role="alert">
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">區別</div>
                    </div>
                    <select class="form-control select-area" name="ClinicReport[area_id][]"><?php
                foreach($areas AS $k => $v) {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                }
                ?></select>
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">NS1 (+)</div>
                    </div>
                    <input type="number" class="form-control" name="ClinicReport[count_p][]" value="0">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">NS1 (-)</div>
                    </div>
                    <input type="number" class="form-control" name="ClinicReport[count_n][]" value="0">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 100%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">備註</div>
                    </div>
                    <input type="number" class="form-control" name="ClinicReport[note][]">
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-success float-right" id="btn-add-area">新增一個區</a>
    <input type="submit" class="btn btn-block btn-primary" value="送出" />
    <?php
    echo $this->Form->end();
    ?>
</div>
<?php
echo $this->Html->script('c/areas/clinic_reports.js');
