<div id="IssuesAdminAdd">
    <h2>匯入</h2>
    <div class="Issues form">
        <?php
        echo $this->Form->create('CdcIssue', array('url' => array('action' => 'import'), 'type' => 'file'));
        echo $this->Form->input('CdcIssue.file', array(
            'type' => 'file',
            'label' => '匯入稽督單',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->end('送出');
        ?>
    </div>
</div>