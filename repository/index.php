<?php

/*$arimModuleData = file_get_contents('http://arim.istu.edu/config/list/');

$numEndPoint = strripos($arimModuleData, '* Internal Modules Information') + 30;
$substrIn = substr($arimModuleData,-strlen($arimModuleData),($numEndPoint));
$newArimModuleData = str_replace($substrIn,'',$arimModuleData);

echo $newArimModuleData;

$res = preg_match_all('/(\* Internal Module\[[0-9]+\]:)/', $newArimModuleData, $matches);
$res2 = preg_split('/(\* Internal Module\[[0-9]+\]:)/', $newArimModuleData);

for ($i = 0; $i < count($res2)-2; $i++)
{
    $res2[$i] = trim($res2[$i+1]);
}
unset($res2[count($res2)-1]);

$writeInJSON = json_encode($res2);
file_put_contents('test.json',$writeInJSON);

$jsonData = file_get_contents('test.json');

echo "<pre>";
print_r($res2);
print_r($jsonData);
echo "</pre>";

echo "<pre>";
//print_r($newArimModuleData."\n".$substrIn);
echo "</pre>";*/

/*print_r(strlen('a10d4144-b5af-4a08-9f6a-a47a858c5ae4'));
echo "\n";
print_r((int)'c');
echo "\n";
print_r(range('a','z'));*/

/*$arrayLetter = range('a','z');
$arrayNumbers = range(0,9);
$appidArray = [];

for ($i = 0; $i < 5; $i++)
{
    $num = [8,4,4,4,12];
    for ($j = 0; $j < $num[$i]; $j++)
    {
        if (rand(1,2) == 1)
        {
            array_push($appidArray,$arrayLetter[rand(0, count($arrayLetter) - 1)]);
        }
        else 
        {
            array_push($appidArray,$arrayNumbers[rand(0, count($arrayNumbers) - 1)]);
        }
    }
    if ($i != 4)
    {
        array_push($appidArray,'-');
    }
}
$appid = implode($appidArray);
print_r($appid);
echo "\n";
print_r(bin2hex(random_bytes(6)));*/

$array = file_get_contents('arim.access/API/data.json');

$data = file_get_contents('arim.access/API/data.json');
$writeInJSON = json_encode($data);

//file_put_contents('test.json',$writeInJSON);

?>

<div id="records">

</div>
<div id="records">
    <input type="text" class='form-control' id='modules1'></input>
    <input type="text" class='form-control' id='modules2'></input>
    <button type="submit" class="form-control md" id="addRecord">Кнопка</button>
    <button type="submit" class="form-control md" id="addRecord">Кнопка</button>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(async () => {
        $(".md").click(() => {
            location.reload();
            if($("#modules1").val() == "")
            {
                console.log('hello world');
            }
        });
        let dataPOST = 0;
        let j = 0;
        let num = 0;
        await $.ajax({
            url: "arim.access/API/getRecords.php",
            method: "POST",
            dataType: "JSON",
            data:"1",
            success:(data) => {
                while(true)
                {
                    if(Object.keys(data).length == 1)
                    {
                        break;
                    }
                    if (j+1 in data)
                    {
                        j++;
                        num++;
                    }
                    else
                    {
                        j++;
                    }
                    if (num == Object.keys(data).length)
                    {
                        break;
                    }
                }
                j++;
                dataPOST = data;
                dataPOST[j] = ""+j;
                dataPOST[j] = {appid:"#appid",key:"#key",description:"discription",modules:"#modules"}
                console.log(dataPOST);
            },
            failure:(data) => {
                console.log(data);
            }
        });
        /*await $.ajax({
            url: "arim.access/API/addRecords.php",
            method: "POST",
            dataType: "JSON",
            data:dataPOST,
            success:(data) => {
                /*$('#modules1').val(data);
                console.log(data);
            },
            failure:(data) => {
                console.log(data);
            }
        });*/
        /*$.getJSON('arim.access/API/data.json',(data) => {
            $('#records').text(Object.keys(data).length);
            //data[Object.keys(data).length + 1] = {desc:"I have this world!",modules:"wizard.sql, list, ping"}
        });*/
        /*$("#addRecord").click(() => {
            $.ajax({
                url: "genappid.php",
                method: "POST",
                dataType: "text",
                data:"1",
                success:(data) => {
                    $('#modules1').val(data);
                    console.log(data);
                },
                failure:(data) => {
                    console.log(data);
                }
            });
            $.ajax({
                url: "genkey.php",
                method: "POST",
                dataType: "text",
                data:"1",
                success:(data) => {
                    $('#modules2').val(data);
                    console.log(data);
                },
                failure:(data) => {
                    console.log(data);
                }
            });
        });*/
    })

    function addNumKey(obj, val) {
        const numKeys = Object.keys(obj).filter(key => !isNaN(key)).sort((a, b) => b - a);
        const nextKeyIndex = numKeys[0] + 1;
        obj[nextKeyIndex] = val;
    }
</script>





