<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="EducationsAdminIndex">
    <h1>區公所填報</h1>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'bureau_add'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="EducationsAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Education.the_date', '日期', array('url' => $url)); ?></th>
                <th>區域</th>
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
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['Education']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <?php echo $this->Html->link('編輯', array('action' => 'bureau_edit', $item['Education']['id']), array('class' => 'btn btn-secondary')); ?>
                        <?php echo $this->Html->link('刪除', array('action' => 'bureau_delete', $item['Education']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>