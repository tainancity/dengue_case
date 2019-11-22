<div id="CdcPointsAdminAdd">
    <?php
    echo $this->Form->create('CdcPoint', array('type' => 'file', 'url' => array('action' => 'edit', $this->data['CdcPoint']['id'])));
    ?>
    <div class="CdcPoints form">
        <h2>編輯列管點</h2>
        <?php
        echo $this->Form->input('CdcPoint.code', array(
            'type' => 'text',
            'label' => '編號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.parent_area_id', array(
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
            'label' => '列管地址',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.issue_people', array(
            'type' => 'text',
            'label' => '查核人',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.issue_note', array(
            'type' => 'textarea',
            'label' => '首次缺失說明',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.issue_type', array(
            'type' => 'text',
            'label' => '調查地區分類',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.issue_date', array(
            'type' => 'text',
            'label' => '抽查日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck_detail', array(
            'type' => 'textarea',
            'label' => '複查結果',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck_result', array(
            'type' => 'text',
            'label' => '複查結果',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck_date', array(
            'type' => 'text',
            'label' => '複查日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck_people', array(
            'type' => 'text',
            'label' => '查核人',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck2_detail', array(
            'type' => 'textarea',
            'label' => '2nd複查說明',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck2_date', array(
            'type' => 'text',
            'label' => '2nd複查日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck2_result', array(
            'type' => 'text',
            'label' => '2nd複查結果',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck2_people', array(
            'type' => 'text',
            'label' => '2nd查核人',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.final_result', array(
            'type' => 'text',
            'label' => '總結果',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcPoint.recheck_ph_detail', array(
            'type' => 'textarea',
            'label' => '衛生局查核',
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
        ?>
    </div>
    <?php
    echo $this->Form->end('儲存');
    ?>
</div>
<script>
    var dbAreaId = '<?php echo $this->data['CdcPoint']['area_id']; ?>';
</script>
<?php
echo $this->Html->script('c/cdc_points/edit.js');
