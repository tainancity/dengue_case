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
        echo $this->Form->input('ClinicReport.type', array(
            'label' => '類型',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('ClinicReport.count_report', array(
            'type' => 'number',
            'label' => '通報件數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('ClinicReport.count_positive', array(
            'type' => 'number',
            'label' => 'NS1 (+)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('ClinicReport.note', array(
            'label' => '備註',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
    </div>
    <input type="submit" class="btn btn-block btn-primary" value="送出" />
    <?php
    echo $this->Form->end();
    ?>
</div>
<?php
echo $this->Html->script('c/areas/clinic_reports.js');
