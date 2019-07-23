<div id="IssuesAdminAdd">
    <?php echo $this->Form->create('Issue', array('type' => 'file')); ?>
    <div class="Issues form">
        <h2>匯入資料</h2>
        <?php
        echo $this->Form->input('Issue.file', array(
            'type' => 'file',
            'label' => '上傳檔案',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
    </div>
    <?php
    echo $this->Form->end('送出');
    ?>
</div>