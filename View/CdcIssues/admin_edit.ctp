<div id="CdcIssuesAdminAdd">
    <?php
    echo $this->Form->create('CdcIssue', array('type' => 'file', 'url' => array('action' => 'edit', $this->data['CdcIssue']['id'])));
    ?>
    <div class="CdcIssues form">
        <h2>編輯稽督單</h2>
        <?php
        echo $this->Form->input('CdcIssue.code', array(
            'type' => 'text',
            'label' => '代號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.date_found', array(
            'type' => 'text',
            'label' => '查核日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.parent_area_id', array(
            'type' => 'select',
            'options' => $areas,
            'label' => '行政區',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.area_id', array(
            'type' => 'select',
            'options' => array(),
            'label' => '里別',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.address', array(
            'label' => '查核地址',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.issue_date', array(
            'type' => 'text',
            'label' => '本署發文日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.issue_no', array(
            'type' => 'text',
            'label' => '疾管南區管文號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.issue_reply_date', array(
            'type' => 'text',
            'label' => '臺南市函復日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.issue_reply_no', array(
            'type' => 'text',
            'label' => '府登防文號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.recheck_date', array(
            'type' => 'text',
            'label' => '複查日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.recheck_ph_detail', array(
            'type' => 'textarea',
            'label' => '複查結果',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.fine', array(
            'type' => 'text',
            'label' => '舉發單',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.note', array(
            'type' => 'textarea',
            'label' => '說明',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.longitude', array(
            'type' => 'text',
            'label' => '經度',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.latitude', array(
            'type' => 'text',
            'label' => '緯度',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        if(!empty($this->data['CdcImage'])) {
            echo '<div class="clearfix"></div>';
            $urlRoot = $this->Html->url('/');
            foreach($this->data['CdcImage'] AS $img) {
                $imgUrl = $urlRoot . 'uploads/' . $img['file'];
                echo '<figure class="figure" style="width: 200px;">';
                echo '<a href="' . $imgUrl . '" target="_blank">';
                echo '<img class="img-thumbnail" src="' . $imgUrl . '" />';
                echo '</a>';
                echo '<figcaption class="figure-caption"><input type="checkbox" name="data[CdcImage][delete][]" value="' . $img['id'] . '" />刪除</figcaption>';
                echo '</figure>';
            }
            echo '<div class="clearfix"></div>';
        }
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
<script>
    var dbAreaId = '<?php echo $this->data['CdcIssue']['area_id']; ?>';
</script>
<?php
echo $this->Html->script('c/cdc_issues/edit.js');
