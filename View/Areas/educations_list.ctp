<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="EducationsAdminIndex">
    <h1>衛教宣導</h1>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'educations'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="EducationsAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Education.the_date', '日期', array('url' => $url)); ?></th>
                <th>區域</th>
                <th>單位</th>
                <th>宣導人次</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('Education.modified', '更新時間', array('url' => $url)); ?></th>
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
                        echo $item['Education']['the_date'];
                        ?></td>
                <td><?php
                        echo $item['Area']['name'];
                        ?></td>
                <td><?php
                        echo $item['Education']['unit'];
                        ?></td>
                <td><?php
                        echo $item['Education']['education'];
                        ?></td>
                <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['Education']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                            <?php echo $this->Html->link('刪除', array('action' => 'educations_delete', $item['Education']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>