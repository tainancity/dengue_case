<?php
if (!isset($url)) {
    $url = array();
}
?>
<div id="IssuesAdminIndex">
    <h2>案例</h2>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'add'), array('class' => 'btn btn-secondary')); ?>
        <?php echo $this->Html->link('匯入', array('action' => 'import'), array('class' => 'btn btn-secondary')); ?>
        <?php echo $this->Html->link('匯出', array('action' => 'export'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="IssuesAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Issue.label', '案例名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Issue.reported', '通報日期', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Issue.name', '姓名', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Issue.cunli', '區里', array('url' => $url)); ?></th>
                <th>建立者</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('Issue.created', '建立時間', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Issue.modified', '更新時間', array('url' => $url)); ?></th>
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
                    <td><?php echo $this->Html->link($item['Issue']['label'], array('action' => 'view', $item['Issue']['id'])); ?></td>
                    <td><?php echo $item['Issue']['reported']; ?></td>
                    <td><?php echo $item['Issue']['name']; ?></td>
                    <td><?php echo $item['Issue']['cunli']; ?></td>
                    <td><?php
                        echo $item['MemberCreated']['username'];
                        ?></td>
                    <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                    <td><?php
                        echo $item['Issue']['created'];
                        ?></td>
                    <td><?php
                        echo $item['Issue']['modified'];
                        ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            
                            <?php echo $this->Html->link('編輯', array('action' => 'edit', $item['Issue']['id']), array('class' => 'btn btn-secondary')); ?>
                            <?php echo $this->Html->link('刪除', array('action' => 'delete', $item['Issue']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                        </div>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="IssuesAdminIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function() {
        });
        //]]>
    </script>
</div>