<fieldset>
    <legend>
        目前位置：首頁 > 最新文章區
    </legend>

    <table style="width: 90%; margin: auto;">
        <tr>
            <th style="width: 25%;" class="ct">標題</th>
            <th style="width: 50%;" class="ct">內容</th>
            <th style="width: 25%;" class="ct"></th>
        </tr>
        <?php

        $allPosts = $Post->count(['status' => 1]);
        $division = 4;
        $allpages = ceil($allPosts/$division);
        $nowpage = $_GET['page'] ?? 1;
        $start = ($nowpage - 1) * $division;
        $rows = $Post->all(['status' => 1], " LIMIT $start, $division");
        foreach($rows as $row):
        ?>
        <tr>
            <td class="post-title clo"><?= $row['title'];?></td>
            <td>
                <span><?= mb_substr($row['content'], 0, 30);?>...</span>
                <span style="display: none;"><?= nl2br($row['content'])?></span>
            </td>
            <td>
                <?php

                if(!empty($_SESSION['login'])){
                    echo "<a href='javascript: good({$row['id']});'>";
                    $check = $Log->count(['user_id' => $_SESSION['login'], 'post_id' => $row['id']]);
                    if($check){
                        echo "收回讚";
                    }else {
                        echo "讚";
                    }
                    echo "</a>";
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
        echo "<a href='?do=news&page=$prepage'> < </a>";
    }

    for($i = 1; $i <= $allpages; $i++){
        $size = ($nowpage == $i) ? '24px' : '18px';
        echo "<a href='?do=news&page=$i' style='font-size: $size'> $i </a>";
    }

    if($nowpage < $allpages){
        $nextpage = $nowpage + 1;
        echo "<a href='?do=news&page=$nextpage'> > </a>";
    }

    ?>
</div>

<script>
    $(".post-title").on("click", function(){
        $(this).next('td').children('span').toggle();
    })

    function good(id){
        $.post("./api/api_good.php", {id}, () => {
            location.reload();
        });
    }
</script>