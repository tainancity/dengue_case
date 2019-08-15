<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'health_edit', $expand['Expand']['id'])));
    ?>
    <div class="Areas form">
        <h1>衛生所填報</h1>
        <div class="row">
            <div class="col">日期： <?php echo $expand['Expand']['the_date']; ?></div>
            <div class="col">地區： <?php echo $expand['Area']['name']; ?></div>
        </div>
        <hr />
        <?php
        echo $this->Form->input('Education.id');
        echo $this->Form->input('Education.education', array(
            'label' => '宣導人次',
            'type' => 'number',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
        <h2>擴採人數及結果</h2>
        <?php
        echo $this->Form->input('Expand.id');
        echo $this->Form->input('Expand.count_p', array(
            'type' => 'number',
            'label' => 'NS1 (+)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Expand.count_n', array(
            'type' => 'number',
            'label' => 'NS1 (-)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Expand.note', array(
            'label' => '備註',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
        <h2>個案家戶發燒追蹤結果</h2>
        <?php
        echo $this->Form->input('Fever.id');
        echo $this->Form->input('Fever.count_people', array(
            'type' => 'number',
            'label' => '個案戶家人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.count_fever', array(
            'type' => 'number',
            'label' => '個案戶家人發燒人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.count_draw', array(
            'type' => 'number',
            'label' => '個案戶家人採血數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.count_p', array(
            'type' => 'number',
            'label' => 'NS1 (+)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.count_n', array(
            'type' => 'number',
            'label' => 'NS1 (-)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.note', array(
            'label' => '備註',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
        <h2>個案住家半徑 50 公尺民眾健康追蹤</h2>
        <?php
        echo $this->Form->input('Track.id');
        echo $this->Form->input('Track.track_count', array(
            'type' => 'number',
            'label' => '社區應追蹤人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Track.track_done', array(
            'type' => 'number',
            'label' => '社區已追蹤人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Track.fever_count', array(
            'type' => 'number',
            'label' => '社區發燒人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Track.fever_draw', array(
            'type' => 'number',
            'label' => '社區發燒採血人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Track.note', array(
            'label' => '備註',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
        <h2>衛生所中心監測孳生源清除</h2>
        <div id="formContainer" class="form-inline">
            <?php foreach($centerSources AS $centerSource) { ?>
            <div class="alert alert-dark cunli-block" role="alert">
                <input type="hidden" name="CenterSource[id][]" value="<?php echo $centerSource['CenterSource']['id']; ?>">
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">里別</div>
                    </div>
                    <select class="form-control select-cunli" name="CenterSource[area_id][]"><?php
                    foreach($cunlis AS $cunliId => $cunliName) {
                        if($centerSource['CenterSource']['area_id'] != $cunliId) {
                            echo '<option value="' . $cunliId . '">' . $cunliName . '</option>';
                        } else {
                            echo '<option value="' . $cunliId . '" selected="selected">' . $cunliName . '</option>';
                        }
                    }
                    ?></select>
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">調查戶數</div>
                    </div>
                    <input type="number" class="form-control" name="CenterSource[investigate][]" value="<?php echo $centerSource['CenterSource']['investigate']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-right" style="width: 10%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">刪除</div>
                    </div>
                    <input type="checkbox" class="form-check-input field-delete" name="CenterSource[delete][]" value="<?php echo $centerSource['CenterSource']['id']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">戶內積水容器</div>
                    </div>
                    <input type="number" class="form-control" name="CenterSource[i_water][]" value="<?php echo $centerSource['CenterSource']['i_water']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">戶內陽性容器</div>
                    </div>
                    <input type="number" class="form-control" name="CenterSource[i_positive][]" value="<?php echo $centerSource['CenterSource']['i_positive']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">戶外積水容器</div>
                    </div>
                    <input type="number" class="form-control" name="CenterSource[o_water][]" value="<?php echo $centerSource['CenterSource']['o_water']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 45%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">戶外陽性容器</div>
                    </div>
                    <input type="number" class="form-control" name="CenterSource[o_positive][]" value="<?php echo $centerSource['CenterSource']['o_positive']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">已處理陽性數</div>
                    </div>
                    <input type="number" class="form-control" name="CenterSource[positive_done][]" value="<?php echo $centerSource['CenterSource']['positive_done']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">舉發單數</div>
                    </div>
                    <input type="number" class="form-control" name="CenterSource[fine][]" value="<?php echo $centerSource['CenterSource']['fine']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 30%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">動員人數</div>
                    </div>
                    <input type="number" class="form-control" name="CenterSource[people][]" value="<?php echo $centerSource['CenterSource']['people']; ?>">
                </div>
                <div class="input-group mb-2 mr-sm-2 float-left" style="width: 100%;">
                    <div class="input-group-prepend">
                        <div class="input-group-text">備註</div>
                    </div>
                    <input type="text" class="form-control field-note" name="CenterSource[note][]" value="<?php echo $centerSource['CenterSource']['note']; ?>">
                </div>
            </div>
            <?php } ?>
        </div>
        <a href="#" class="btn btn-success float-right" id="btn-add-cunli">新增一個里</a>
    </div>
    <input type="submit" class="btn btn-block btn-primary" value="送出" />
    <?php
    echo $this->Form->end();
    ?>
</div>
<?php
echo $this->Html->script('c/areas/health_edit.js');
