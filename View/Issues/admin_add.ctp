<div id="IssuesAdminAdd">
    <?php echo $this->Form->create('Issue', array('type' => 'file')); ?>
    <div class="Issues form">
        <h2>新增案例</h2>
        <?php
        echo $this->Form->input('Issue.code', array(
            'label' => '通報編號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.label', array(
            'label' => '案例名稱',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.report_type', array(
            'legend' => '通報類型',
            'type' => 'radio',
            'options' => $this->Olc->reportTypes,
            'div' => 'form-group',
            'class' => 'form-check form-check-inline',
        ));
        echo $this->Form->input('Issue.reported', array(
            'type' => 'text',
            'label' => '通報日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.confirmed', array(
            'type' => 'text',
            'label' => '確診日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.date_onset', array(
            'type' => 'text',
            'label' => '發病日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.name', array(
            'label' => '姓名',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.address', array(
            'label' => '居住地',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.cunli', array(
            'label' => '區里',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.longitude', array(
            'type' => 'text',
            'label' => '經度',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.latitude', array(
            'type' => 'text',
            'label' => '緯度',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Issue.igm', array(
            'legend' => 'IgM',
            'type' => 'radio',
            'options' => $this->Olc->igmOptions,
            'div' => 'form-group',
            'class' => 'form-check form-check-inline',
        ));
        echo $this->Form->input('Issue.igg', array(
            'legend' => 'IgG',
            'type' => 'radio',
            'options' => $this->Olc->iggOptions,
            'div' => 'form-group',
            'class' => 'form-check form-check-inline',
        ));
        ?>
    </div>
    <?php
    echo $this->Form->end('送出');
    ?>
</div>
<?php
echo $this->Html->script('c/issues/add.js');
