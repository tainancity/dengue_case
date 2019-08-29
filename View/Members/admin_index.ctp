<div id="MembersAdminIndex">
    <h2>使用者</h2>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'add'), array('class' => 'btn btn-secondary')); ?>
        <?php echo $this->Html->link('群組', array('controller' => 'groups'), array('class' => 'btn btn-secondary')); ?>
        <?php echo $this->Html->link('權限更新', array('action' => 'acos'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <?php
    echo '搜尋: ' . $this->Form->text('Member.filter', array(
        'id' => 'memberFilter',
        'value' => $keyword,
    ));
    ?>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="MembersAdminIndexTable">
        <tr>
            <th>區域單位</th>
            <th><?php echo $this->Paginator->sort('username', '帳號'); ?></th>
            <th><?php echo $this->Paginator->sort('user_status', '狀態'); ?></th>
            <th><?php echo $this->Paginator->sort('created', '建立時間'); ?></th>
            <th><?php echo $this->Paginator->sort('modified', '更新時間'); ?></th>
            <th class="actions">操作</th>
        </tr>
        <?php
        $i = 0;
        foreach ($members as $member):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
        <tr<?php echo $class; ?>>
            <td><?php echo $member['Area']['name'] . $member['Member']['unit']; ?></td>
            <td>
                    <?php echo $member['Member']['username']; ?>
            </td>
            <td>
                    <?php echo $member['Member']['user_status']; ?>
            </td>
            <td>
                    <?php echo $member['Member']['created']; ?>
            </td>
            <td>
                    <?php echo $member['Member']['modified']; ?>
            </td>
            <td class="actions">
                <div class="btn-group">
                    <?php echo $this->Html->link('檢視', array('action' => 'view', $member['Member']['id']), array('class' => 'btn btn-secondary')); ?>
                    <?php echo $this->Html->link('編輯', array('action' => 'edit', $member['Member']['id']), array('class' => 'btn btn-secondary')); ?>
                    <?php echo $this->Html->link('刪除', array('action' => 'delete', $member['Member']['id']), array('class' => 'btn btn-secondary'), '確定要刪除？'); ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="MembersAdminIndexPanel"></div>
    <?php
    $jsUri = $this->Html->url() . '/index';
    ?>
    <script>
        $(function () {
            $('#memberFilter').autocomplete({
                delay: 1000,
                minLength: 0,
                search: function (event, ui) {
                    var targetUri = '<?php echo $jsUri; ?>/keyword:' + $(this).val();
                    $('#MembersAdminIndex').parent().load(encodeURI(targetUri));
                    return false;
                }
            });
        });
    </script>
</div>