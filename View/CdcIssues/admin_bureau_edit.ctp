<div id="CdcIssuesAdminAdd">
    <?php
    echo $this->Form->create('CdcIssue', array('type' => 'file', 'url' => array('action' => 'bureau_edit', $this->data['CdcIssue']['id'])));
    ?>
    <div class="CdcIssues form">
        <h2>編輯稽查點</h2>
        <table class="table table-bordered">
            <tr>
                <td>代號</td>
                <td><?php echo $this->request->data['CdcIssue']['code']; ?></td>
            </tr>
            <tr>
                <td>查核日期</td>
                <td><?php echo $this->request->data['CdcIssue']['date_found']; ?></td>
            </tr>
            <tr>
                <td>區域</td>
                <td><?php echo $this->request->data['Area']['Parent']['name'] . $this->request->data['Area']['name']; ?></td>
            </tr>
            <tr>
                <td>查核地址</td>
                <td><?php echo $this->request->data['CdcIssue']['address']; ?></td>
            </tr>
            <tr>
                <td>本署發文日期</td>
                <td><?php echo $this->request->data['CdcIssue']['issue_date']; ?></td>
            </tr>
            <tr>
                <td>文號</td>
                <td><?php echo $this->request->data['CdcIssue']['issue_no']; ?></td>
            </tr>
            <tr>
                <td>臺南市函復日期</td>
                <td><?php echo $this->request->data['CdcIssue']['issue_reply_date']; ?></td>
            </tr>
            <tr>
                <td>文號</td>
                <td><?php echo $this->request->data['CdcIssue']['issue_reply_no']; ?></td>
            </tr>
        </table>
        <?php
        echo $this->Form->input('CdcIssue.recheck_date', array(
            'type' => 'text',
            'label' => '複查日期',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('CdcIssue.recheck_result', array(
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
            'label' => '備註',
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
<?php
echo $this->Html->script('c/cdc_points/add.js');
