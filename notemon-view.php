<?php
    $instance_folder = '';
    if (isset($_GET['instance']))
        $instance_folder = $_GET['instance'];
    $instance_path = "../notemon__root/$instance_folder/records/";

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>NOTEMONView<?php echo $instance_folder==''?'':" for $instance_folder"?></title>
        <link rel="stylesheet" href="/css/PaperUI/style.css" />
        <link rel="stylesheet" href="/css/PaperUI/theme-fix.css" />
        <link rel="icon" href="./pen.png" />
        <style>
            p {
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <div class="paperui-paper header">
            
            <div class="header-center-wrap">
                <div class="header-logo">
                    <a href="?"><img src="./pen.png" /></a>
                </div>
                <div class="header-label">NOTEMONView</div>
            </div>
            
        </div>
        <div class="content-container">
            <div id="content" class="paperui-paper content">
                <?php
                    if ($instance_folder != ''){
                        if (is_dir($instance_path)){
                            if (isset($_GET['record'])){
                                $record_file = $_GET['record'];
                                if (is_file($instance_path.$record_file)){
                                    $M = substr($record_file,0,2);
                                    $D = substr($record_file,2,2);
                                    $h = substr($record_file,5,2);
                                    $m = substr($record_file,7,2);
                                    $s = substr($record_file,9,2);
                                    $time = "{$M}月{$D}日 $h:$m:$s";
                                    echo <<<END
                                    <p>现在查看的是{$time}的记录。</p>
                                    <p><a href="?instance=$instance_folder">返回记录列表</a></p>
                                    END;
                                    $text = file_get_contents($instance_path.$record_file);
                                    echo "<textarea readonly style=\"font-size: 16px;width: calc(100% - 20px);height: 600px;\">$text</textarea>";
                                }else{
                                    echo '不对...是你修改了URL参数吗？...还是我没把程序写好？...';
                                }
                            }else{
                                $files_array = scandir($instance_path);
                                //echo '<pre>'; print_r($files_array); echo '</pre>';
                                echo '<p style="margin: 0 0 10px 0;">请选择你要查看的记录。</p>';
                                foreach ($files_array as $f){
                                    if ($f != '.' and $f != '..') {
                                        $M = substr($f,0,2);
                                        $D = substr($f,2,2);
                                        $h = substr($f,5,2);
                                        $m = substr($f,7,2);
                                        $s = substr($f,9,2);
                                        $a_text = "{$M}月{$D}日 $h:$m:$s";
                                        echo <<<END
                                        <p><a href="?instance=$instance_folder&record=$f">$a_text</a></p>\n
                                        END;
                                    }
                                }
                            }
                        }else{
                            echo <<<END
                            <p>$instance_folder 实例不存在。</p>
                            <p><a href="?">返回查询</a></p>
                            END;

                        }
                        
                    }else{
                        echo <<<END
                        <p>Please specify an instance to view.</p>
                        <form>
                            <label for="instance">实例名：</label>
                            <input id="instance" type="text" name="instance">
                        </form>
                        <form>
                            <input type="button" value="查询" onclick="lookup()" style="margin-left: 0;">
                        </form>
                        END;
                    }

                ?>

            </div>
        </div>
        <div class="simple-footer">
            Written with PHP, <a href="https://github.com/Remelens/PaperUI" alt="paperui">PaperUI</a>, Pinkerizer Palette and ❤️.
        </div>
        <script>
            function lookup() {
                var instance = document.getElementById("instance").value;
                window.open("?instance="+instance, "_self");
            }
        </script>
    </body>
</html>