<table class="table table-bordered">
    <tr>
        <th>區域單位</th>
        <th>帳號</th>
        <th>密碼</th>
    </tr>
        <?php
        $i = 0;
        foreach ($accounts as $account) {
            echo '<tr>';
            echo '<td>' . $account[0] . '</td>';
            echo '<td>' . $account[1] . '</td>';
            echo '<td>' . $account[2] . '</td>';
            echo '</tr>';
        }
            ?>
</table>