<div id="GroupsAdminIndex">
    <h2>群組</h2>
    <div class="btn-group">
        <?php if ($parentId > 0): ?>
            <?php echo $this->Html->link('上一層', array('action' => 'index', $upperLevelId), array('class' => 'btn btn-secondary')); ?>
        <?php endif; ?>
        <?php echo $this->Html->link('新增', array('action' => 'add', $parentId), array('class' => 'btn btn-secondary')); ?>
        <?php echo $this->Html->link('使用者', array('controller' => 'members'), array('class' => 'btn btn-secondary')); ?>
        <?php echo $this->Html->link('群組權限', array('controller' => 'group_permissions'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="GroupsAdminIndexTable">
        <tr>
            <th><?php echo $this->Paginator->sort('name', '名稱'); ?></th>
            <th class="actions">操作</th>
        </tr>
        <?php
        $i = 0;
        foreach ($groups as $group):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <?php echo $group['Group']['name']; ?>
                </td>
                <td>
                    <div class="btn-group">
                        <?php echo $this->Html->link('編輯', array('action' => 'edit', $group['Group']['id']), array('class' => 'btn btn-secondary')); ?>
                        <?php echo $this->Html->link('刪除', array('action' => 'delete', $group['Group']['id']), array('class' => 'btn btn-secondary'), __('Delete the item, sure?', true)); ?>
                        <?php echo $this->Html->link('下一層', array('action' => 'index', $group['Group']['id']), array('class' => 'btn btn-secondary')); ?>
                        <?php echo $this->Html->link('產生區公所帳號', array('controller' => 'members', 'action' => 'areas', $group['Group']['id'], '區公所'), array('class' => 'btn btn-secondary')); ?>
                        <?php echo $this->Html->link('產生衛生所帳號', array('controller' => 'members', 'action' => 'areas', $group['Group']['id'], '衛生所'), array('class' => 'btn btn-secondary')); ?>
                        <?php
                        if ($group['Group']['id'] != 1) {
                            echo $this->Html->link('權限', array('controller' => 'group_permissions', 'action' => 'group', $group['Group']['id']), array('class' => 'btn btn-secondary'));
                        }
                        ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="GroupsAdminIndexPanel"></div>
</div>