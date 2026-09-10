<fieldset>
    <legend>
        目前位置：首頁 > 人氣文章區
    </legend>

    <table style="width: 90%; margin: auto;">
        <tr>
            <th style="width: 25%;" class="ct">標題</th>
            <th style="width: 50%;" class="ct">內容</th>
            <th style="width: 25%;" class="ct">人氣</th>
        </tr>
        <?php

        $allPosts = $Post->count(['status' => 1]);
        $division = 4;
        $allpages = ceil($allPosts/$division);
        $nowpage = $_GET['page'] ?? 1;
        $start = ($nowpage - 1) * $division;
        $rows = $Post->all(['status' => 1], " ORDER BY `likes` DESC LIMIT $start, $division");
        foreach($rows as $row):
        ?>
        <tr>
            <td class="post-title clo" style="padding: 20px;"><?= $row['title'];?></td>
            <td style="position: relative;">
                <span><?= mb_substr($row['content'], 0, 30);?>...</span>
                <div class="alerr" style="position: absolute; left: -50%; width: 200%">
                    <h3><?= $row['title']?></h3>
                    <pre class="ssaa"><?= nl2br($row['content'])?></pre>
                </div>
            </td>
            <td>
                <?= $row['likes'];?>個人說<span class="good"></span>
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
    $(".post-title").hover(
        function(){
            $(".alerr").hide();
            $(this).next("td").children(".alerr").show();
        }, function(){
            $(".alerr").hide();
        }
    );

    $(".alerr").hover(
        function(){
            $(this).show();
        }, function(){
            $(".alerr").hide();
        }
    );

    function good(id){
        $.post("./api/api_good.php", {id}, () => {
            location.reload();
        });
    }
</script>