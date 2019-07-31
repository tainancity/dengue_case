<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'bureau_sources')));
    ?>
    <div class="Areas form">
        <h1>各局處轄管防疫動員</h1>
        <?php
        echo $this->Form->input('BureauSource.the_date', array(
            'label' => '日期',
            'type' => 'text',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.unit', array(
            'type' => 'select',
            'label' => '局處',
            'options' => array(
                '環保局' => '環保局',
                '工務局' => '工務局',
                '民政局' => '民政局',
                '教育局' => '教育局',
                '水利局' => '水利局',
                '經發局' => '經發局',
            ),
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.investigate', array(
            'type' => 'number',
            'label' => '檢查地點數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.i_water', array(
            'type' => 'number',
            'label' => '戶內積水容器',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.i_positive', array(
            'type' => 'number',
            'label' => '戶內陽性容器',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.o_water', array(
            'type' => 'number',
            'label' => '戶外積水容器',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.o_positive', array(
            'type' => 'number',
            'label' => '戶外陽性容器',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.positive_done', array(
            'type' => 'number',
            'label' => '已處理陽性數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.education', array(
            'type' => 'number',
            'label' => '宣導人次',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.people', array(
            'type' => 'number',
            'label' => '動員人次',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.location', array(
            'label' => '檢查地點（名稱）',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('BureauSource.note', array(
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
echo $this->Html->script('c/areas/bureau_sources.js');
