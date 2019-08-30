<div id="CdcPointsAdminAdd">
    <?php
    echo $this->Form->create('CdcPoint', array('type' => 'file', 'url' => array('action' => 'add')));
    ?>
    <div class="CdcPoints form">
        <h2>新增稽查點</h2>
        <?php
        echo $this->Form->input('CdcPoint.code', array(
            'type' => 'text',
            'label' => '代號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.date_found', array(
            'type' => 'text',
            'label' => '查核日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.parent_id', array(
            'type' => 'select',
            'options' => $areas,
            'label' => '行政區',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.area_id', array(
            'type' => 'select',
            'options' => array(),
            'label' => '里別',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.address', array(
            'label' => '查核地址',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.issue_date', array(
            'type' => 'text',
            'label' => '本署發文日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.issue_no', array(
            'type' => 'text',
            'label' => '文號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.issue_reply_date', array(
            'type' => 'text',
            'label' => '臺南市函復日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.issue_reply_no', array(
            'type' => 'text',
            'label' => '文號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck_date', array(
            'type' => 'text',
            'label' => '複查日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck_result', array(
            'type' => 'textarea',
            'label' => '複查結果',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.fine', array(
            'type' => 'text',
            'label' => '舉發單',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.note', array(
            'type' => 'textarea',
            'label' => '備註',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.longitude', array(
            'type' => 'text',
            'label' => '經度',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.latitude', array(
            'type' => 'text',
            'label' => '緯度',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcImage.file.', array(
            'type' => 'file',
            'multiple' => 'multiple',
            'label' => '上傳圖片',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
    </div>
    <?php
    echo $this->Form->end('儲存');
    ?>
</div>
<?php
echo $this->Html->script('c/cdc_points/add.js');
