<?

if(isset($_POST)) {
    $data = genAppID();
    echo $data;
}

function genAppID() 
{
    $arrayLetter = range('a','z');
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
    return $appid;
}