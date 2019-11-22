<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="CdcIssuesAdminIndex">
    <h1>疾管署稽督單</h1>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="CdcIssuesAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('CdcIssue.date_found', '日期', array('url' => $url)); ?></th>
                <th>區域</th>
                <th>住址</th>
                <th>狀態</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('CdcIssue.modified', '更新時間', array('url' => $url)); ?></th>
                <th class="actions">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($items as $item) {
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
            <tr<?php echo $class; ?>>
                <td><?php
                echo $item['CdcIssue']['date_found'];
                        ?></td>
                <td><?php
                        echo $item['Area']['Parent']['name'] . $item['Area']['name'];
                        ?></td>
                <td><?php
                echo $item['CdcIssue']['address'];
                        ?></td>
                <td><?php
                        if(!empty($item['CdcIssue']['recheck_date'])) {
                            echo '<span style="color: green;">已回應</span>';
                        } else {
                            echo '<span style="color: red;">未回應</span>';
                        }
                        ?></td>
                <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['CdcIssue']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <?php echo $this->Html->link('編輯', array('action' => 'bureau_edit', $item['CdcIssue']['id']), array('class' => 'btn btn-secondary')); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>