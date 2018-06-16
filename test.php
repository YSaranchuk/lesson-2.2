<?php
$file_list = glob('uploads/*.json');
$test = [];
foreach ($file_list as $key => $file) {
    if ($key == $_GET['test']) {  
        $file_test = file_get_contents($file_list[$key]);
        $decode_file = json_decode($file_test, true);
        $test = $decode_file;
    }
}
$questions = $test['questions']; 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>2.2 «Обработка форм» - Тест </title>
    <meta charset="UTF-8">
    <style>
        .container { max-width: 950px; margin: 0 auto; }
        h1 {margin-bottom: 0.2em;}
        li {margin: 3px 0;}
        .button {margin: 15px;}
        .answer:hover {text-decoration: underline;}
    </style>
</head>
<body>
<div class="container">
    <h2>Меню:</h2>
    <ul>
        <li><a href="admin.php">Форма загрузки тестов</a></li>
        <li><a href="list.php">Список тестов</a></li>
    </ul>

    <h2>Тест: <?=$test['title']?></h2>
    <form method="post">
        <fieldset>
            <?php
            $post_true = 0; 
            $post_false = 0; 
            $result_true = 0; 
            foreach ($questions as $key1 => $number) : 
                $question = $number['question']; 
                $answers[] = $number['answers']; 
                ?>
                <h4>Вопрос: <?=$question;?></h4>
                <?php
                foreach ($answers[$key1] as $key2 => $item) :
                    if ($item['result'] === true) {
                        $result_true++; 
                    };
                    if (count($_POST) > 0) { 
                        $answers_key = "$key1-$key2"; 
                        if (isset($_POST[$answers_key])) { 
                            global $selected;
                            $selected = "checked";
                            if ($item['result'] === true) { 
                                $post_true++; 
                            } else {
                                $post_false++; 
                            }
                        } else {
                            $selected = "";
                        }
                    } else {
                        $selected = "";
                    };
                    ?>
                    <label class="answer">
                        <input type="checkbox" name="<?php echo $key1."-".$key2;?>" value="<?php echo $key1."-".$key2;?>" <?=$selected?>>
                        <?=$item['answer'];?>
                    </label>
                <?php
                endforeach; 
                ?>

            <?php
            endforeach;
            
            if (count($_POST) > 0) {
                if ($post_true === $result_true && $post_false === 0) {
                    echo '<h4>Результат: Правильно!</h4>';
                }elseif ($post_true > 0 && $post_false <> 0) {
                    echo '<h4>Результат: Ну почти =) (попробуйте еще)</h4>';
                }else{
                    echo '<h4>Результат: Вы ошиблись =(</h4>';
                }
            }
            ?>
        </fieldset>
        <input class="button" type="submit" value="Отправить">
    </form>

</div>
</body>
</html>
