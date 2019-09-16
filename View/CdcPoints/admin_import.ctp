<div id="IssuesAdminAdd">
    <h2>匯入</h2>
    <div class="Issues form">
        <?php
        echo $this->Form->create('CdcPoint', array('url' => array('action' => 'import'), 'type' => 'file'));
        echo $this->Form->input('CdcPoint.file', array(
            'type' => 'file',
            'label' => '匯入稽督單',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->end('送出');
        ?>
    </div>
    <hr />
    <div class="Issues form">
        <?php
        echo $this->Form->create('CdcPoint', array('url' => array('action' => 'import_case'), 'type' => 'file'));
        echo $this->Form->input('CdcPoint.file', array(
            'type' => 'file',
            'label' => '匯入列管點',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->end('送出');
        ?>
    </div>
</div>