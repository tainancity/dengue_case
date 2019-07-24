<div id="IssuesAdminAdd">
    <h2>匯入資料</h2>
    <div class="Issues form">
        <?php
        echo $this->Form->create('Issue', array('url' => array('action' => 'import'), 'type' => 'file'));
        echo $this->Form->input('Issue.file', array(
            'type' => 'file',
            'label' => '匯入案例資料',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->end('送出');
        ?>
    </div>
    <hr />
    <div class="Issues form">
        <?php
        echo $this->Form->create('Issue', array('url' => array('action' => 'import_report'), 'type' => 'file'));
        echo $this->Form->input('Issue.file', array(
            'type' => 'file',
            'label' => '匯入通報資料',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->end('送出');
        ?>
    </div>
</div>