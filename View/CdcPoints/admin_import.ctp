<div id="IssuesAdminAdd">
    <h2>匯入稽督單</h2>
    <div class="Issues form">
        <?php
        echo $this->Form->create('CdcPoint', array('url' => array('action' => 'import'), 'type' => 'file'));
        echo $this->Form->input('CdcPoint.file', array(
            'type' => 'file',
            'label' => '匯入',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->end('送出');
        ?>
    </div>
</div>