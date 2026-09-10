<fieldset>
    <legend>
        目前位置：首頁 > 問卷調查
    </legend>

    <table style="width: 90%; margin: auto;">
        <tr>
            <th style="width: 10%;" class="ct">編號</th>
            <th style="width: 50%;" class="ct">問卷題目</th>
            <th style="width: 15%;" class="ct">投票總數</th>
            <th style="width: 10%;" class="ct">結果</th>
            <th style="width: 15%;" class="ct">狀態</th>
        </tr>
        <?php

        $totalques = $Survey->count(['parent_id' => 0]);
        $division = 4;
        $allpages = ceil($totalques/$division);
        $nowpage = $_GET['p'] ?? 1;
        $start = ($nowpage - 1) * $division;
        $rows = $Survey->all(['parent_id' => 0], " LIMIT $start, $division");
        foreach($rows as $key => $value):
        ?>
        <tr>
            <td class="post-title"><?= $key + 1;?></td>
            <td class="post-title"><?= $value['title'];?></td>
            <td class="post-title"><?= $value['vote'];?></td>
            <td>
                <a href="?do=result&id=<?= $value['id'];?>">結果</a>
            </td>
            <td>
                <?php

                if(isset($_SESSION['login'])){
                    echo "<a href='?do=vote&id={$value['id']}'>參與投票</a>";
                }else {
                    echo "請先登錄";
                }
                ?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</fieldset>

<div class="ct">
    <?php

    if($nowpage > 1){
        $prepage = $nowpage - 1;
        echo "<a href='?do=news&p=$prepage'> < </a>";
    }

    for($i = 1; $i <= $allpages; $i++){
        $size = ($nowpage == $i) ? '24px' : '18px';
        echo "<a href='?do=news&p=$i' style='font-size: $size'> $i </a>";
    }

    if($nowpage < $allpages){
        $nextpage = $nowpage + 1;
        echo "<a href='?do=news&p=$nextpage'> > </a>";
    }

    ?>
</div>