<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Arim access");

use Bitrix\Main\UI\Extension;
Extension::load('ui.bootstrap4');

/*use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/script.js");*/
//Asset::getInstance()->addString("<script src='script.js'></script>");

/*$APPLICATION->AddHeadScript($this->GetFolder()."/script.js");*/

//$APPLICATION->addExternalJS("script.js");

$arimModuleData = file_get_contents('http://arim.istu.edu/config/list/');

$numEndPoint = strripos($arimModuleData, '* Internal Modules Information') + 30;
$substrIn = substr($arimModuleData,-strlen($arimModuleData),($numEndPoint));
$newArimModuleData = str_replace($substrIn,'',$arimModuleData);

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
$data = json_decode($jsonData);

?>
<!--<script href='script.js'></script>-->

<h2 class='text-center'>Заголовок для текста</h2>

<div class='form-row' style="margin-right: 0px; padding-bottom: 10px;">
    <button type="submit" id="openAddModalForm" class="btn btn-primary">Добавить запись</button>
    <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddForm">Запустить модальное окно</button>-->
</div>
<div class='form-row' style="margin-right: 0px; padding-bottom: 10px;">
    <div class='container' id='records' style="margin-left: 0px; max-width: none;"></div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalAddForm" tabindex="-1" role="dialog" aria-labelledby="modalAddForm" aria-hidden="true"><!--aria-labelledby="myLargeModalLabel"-->
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class='row'>
                        <div class='col'>
                            <label for='description'>Описание</label>
                            <textarea class='form-control' id='description' rows='10'></textarea>
                        </div>

                        <div class='col'>
                            <label for='bm'>Модули</label>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <input type="text" class='form-control' id='modules' readonly></input>
                                </div>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <button type='submit' class='btn btn-primary form-control' onclick="znachSelect()">Добавить</button>
                                </div>
                                <div class='col'>
                                    <button type='submit' class='btn btn-primary form-control' onclick="znachDelete()">Удалить</button> 
                                </div>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <select id="modulesselect" class="form-control" placeholder="Readonly input here…">
                                    <?for ($i = 0; $i <= count($data)-1; $i++){?>
                                        <option value="<?echo $data[$i];?>"><?echo $data[$i];?></option>
                                    <?}?>
                                </select>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <label for='appid'>appid</label>
                                    <input type="text" class='form-control' id='appid' readonly></input>
                                </div>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <label for='key'>Ключ</label>
                                    <input type="text" class='form-control' id='key' readonly></input>
                                </div>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <button type='submit' class='btn btn-primary form-control' name="Add" onclick="gen(this)">Сгенерировать appid и ключ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary addRecord" data-dismiss="modal">Сохранить запись</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalChangeForm" tabindex="-1" role="dialog" aria-labelledby="modalChangeForm" aria-hidden="true"><!--aria-labelledby="myLargeModalLabel"-->
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Изменения </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class='row'>
                        <div class='col'>
                            <label for='description'>Описание</label>
                            <textarea class='form-control' id='descriptionC' rows='10'></textarea>
                        </div>
                        <input type="text" class="form-control" id="num" hidden="true"></input>
                        <div class='col'>
                            <label for='bm'>Модули</label>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <input type="text" class='form-control' id='modulesC' readonly></input>
                                </div>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <button type='submit' class='btn btn-primary form-control' onclick="znachSelectC()">Добавить</button>
                                </div>
                                <div class='col'>
                                    <button type='submit' class='btn btn-primary form-control' onclick="znachDeleteC()">Удалить</button> 
                                </div>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <select id="modulesselectC" class="form-control" placeholder="Readonly input here…">
                                    <?for ($i = 0; $i <= count($data)-1; $i++){?>
                                        <option value="<?echo $data[$i];?>"><?echo $data[$i];?></option>
                                    <?}?>
                                </select>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <label for='appidC'>appid</label>
                                    <input type="text" class='form-control' id='appidC' readonly></input>
                                </div>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <label for='keyC'>Ключ</label>
                                    <input type="text" class='form-control' id='keyC' readonly></input>
                                </div>
                            </div>
                            <div class='form-row' id='bm' style="margin-right: 0px; padding-bottom: 10px;">
                                <div class='col'>
                                    <button type='submit' class='btn btn-primary form-control' name="Change" onclick="gen(this)">Сгенерировать appid и ключ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary changeRecord" data-dismiss="modal">Изменить запись</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">
    let inputModules = document.querySelector('#modules');
    let selectModules = document.querySelector('#modulesselect');
    let selectModulesC = document.querySelector('#modulesselectC');
    let recordsArray = document.querySelector('#records');

    function znachSelect() 
    {
        event.preventDefault();
        if (document.getElementById('modules').value.includes(selectModules.value))
        {
            alert('Данный модуль уже добавлен.');
        }
        else
        {
            if (document.getElementById('modules').value.length == 0)
            {
                //event.preventDefault();
                document.getElementById('modules').value = selectModules.value;
            }
            else
            {
                //event.preventDefault();
                document.getElementById('modules').value += ', '+selectModules.value;
            }
        }
    }
    function znachSelectC() 
    {
        event.preventDefault();
        if (document.getElementById('modulesC').value.includes(selectModulesC.value))
        {
            alert('Данный модуль уже добавлен.');
        }
        else
        {
            if (document.getElementById('modulesC').value.length == 0)
            {
                //event.preventDefault();
                document.getElementById('modulesC').value = selectModulesC.value;
            }
            else
            {
                //event.preventDefault();
                document.getElementById('modulesC').value += ', '+selectModulesC.value;
            }
        }
    }

    function znachDelete()
    {
        event.preventDefault();
        if (!document.getElementById('modules').value.includes(selectModules.value))
        {
            alert('Данного модуля нет среди выбранных вами.');
        }
        else
        {
            if (document.getElementById('modules').value.length == selectModules.value.length)
            {
                document.getElementById('modules').value = '';
            }
            else if ((document.getElementById('modules').value.indexOf(selectModules.value)+(selectModules.value.length-1)) == (document.getElementById('modules').value.length-1))
            {
                document.getElementById('modules').value = document.getElementById('modules').value.slice(0,document.getElementById('modules').value.indexOf(selectModules.value)-2)+
                document.getElementById('modules').value.slice(document.getElementById('modules').value.indexOf(selectModules.value) + selectModules.value.length);
            }
            else
            {
                document.getElementById('modules').value = document.getElementById('modules').value.slice(0,document.getElementById('modules').value.indexOf(selectModules.value))+
                document.getElementById('modules').value.slice(document.getElementById('modules').value.indexOf(selectModules.value) + selectModules.value.length + 2);
            }
        }
    }
    function znachDeleteC()
    {
        event.preventDefault();
        if (!document.getElementById('modulesC').value.includes(selectModulesC.value))
        {
            alert('Данного модуля нет среди выбранных вами.');
        }
        else
        {
            if (document.getElementById('modulesC').value.length == selectModulesC.value.length)
            {
                document.getElementById('modulesC').value = '';
            }
            else if ((document.getElementById('modulesC').value.indexOf(selectModulesC.value)+(selectModulesC.value.length-1)) == (document.getElementById('modulesC').value.length-1))
            {
                document.getElementById('modulesC').value = document.getElementById('modulesC').value.slice(0,document.getElementById('modulesC').value.indexOf(selectModulesC.value)-2)+
                document.getElementById('modulesC').value.slice(document.getElementById('modulesC').value.indexOf(selectModulesC.value) + selectModulesC.value.length);
            }
            else
            {
                document.getElementById('modulesC').value = document.getElementById('modulesC').value.slice(0,document.getElementById('modulesC').value.indexOf(selectModulesC.value))+
                document.getElementById('modulesC').value.slice(document.getElementById('modulesC').value.indexOf(selectModulesC.value) + selectModulesC.value.length + 2);
            }
        }
    }
    function md(button)
    {
        $.ajax({
                url: "API/getRecords.php",
                method: "POST",
                dataType: "JSON",
                data: "1",
                success:(data) => {
                    $("#num").val($(button).attr("name"));
                    $("#descriptionC").val(data[$(button).attr("name")].description);
                    $("#modulesC").val(data[$(button).attr("name")].modules);
                    $("#appidC").val(data[$(button).attr("name")].appid);
                    $("#keyC").val(data[$(button).attr("name")].key);
                },
                failure:(data) => {
                    console.log(data);
                }
        });
    }
    async function deleteRecords(button) //Удаление-----------------------------------------------------------------------------------------------------------------------------------
    {
        try 
        {
            console.log("Кнопка нажимается");
            let j = $(button).attr("name");
            let dataPOST = 0;
            await $.ajax({
                url: "API/getRecords.php",
                method: "POST",
                dataType: "JSON",
                data:"1",
                success:(data) => {
                    dataPOST = data;
                    delete dataPOST[j];
                    console.log(dataPOST);
                },
                failure:(data) => {
                    console.log(data);
                }
            });
            await $.ajax({
                url: "API/addRecords.php",
                method: "POST",
                dataType: "JSON",
                data: dataPOST == {} ? {} : dataPOST,
                success:(data) => {
                    console.log(data);
                },
                failure:(data) => {
                    console.log(data);
                }
            });
        } 
        catch (error) 
        {
            document.location.reload();
            console.log('Error',error);
        }
        
    }
    function gen(button)
    {
        event.preventDefault();
        $.ajax({
            url: "genappid.php",
            method: "POST",
            dataType: "text",
            data:"1",
            success:(data) => {
                if ($(button).attr("name") == 'Add')
                {
                    $('#appid').val(data);
                }
                else
                {
                    $('#appidC').val(data);
                }
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
                if ($(button).attr("name") == 'Add')
                {
                    $('#key').val(data);
                }
                else
                {
                    $('#keyC').val(data);
                }
            },
            failure:(data) => {
                console.log(data);
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(() => {
        $.ajax({
            url: "API/getRecords.php",
            method: "POST",
            dataType: "JSON",
            data:"1",
            success:(data) => {
                console.log(data);
                let j = 0;
                let num = 0;
                while(true)
                {
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
                for(let i = 1; i <= j; i++)
                {
                    if (i in data)
                    {
                        $('#records').append(
                            '<div class="form-row" style="margin-right: 0px; padding-bottom: 10px;">'+
                                '<div class="col-7">'+
                                    '<div class="form-control form-row" style="margin-right: 0px; padding-bottom: 10px;">'+
                                        '<div class="col" id="n'+i+'" style="flex-basis: content;">'+i+')'+'</div>'+
                                        '<div class="col" id="a'+i+'" style="flex-basis: content;">'+data[i].appid+'</div>'+
                                        '<div class="col" id="k'+i+'" style="flex-basis: content;">'+data[i].key+'</div>'+
                                        '<div class="col" id="d'+i+'" style="flex-basis: content;">'+data[i].description.substring(0,10)+'...'+'</div>'+
                                        '<div class="col" id="m'+i+'" style="flex-basis: content;">'+data[i].modules.substring(0,15)+'...'+'</div>'+
                                    '</div>'+   
                                '</div>'+
                                '<div class="col-auto">'+
                                    '<button type="submit" class=" btn btn-primary md" name="'+i+'" onclick="md(this)" data-toggle="modal" data-target="#modalChangeForm">Изменить запись</button>'+
                                '</div>'+
                                '<div class="col-auto">'+
                                    '<button type="submit" class=" btn btn-primary deleteRecords" onclick="deleteRecords(this)" name="'+i+'">Удалить запись</button>'+
                                '</div>'+
                            '</div>'
                        );
                    }
                }
            },
            failure:(data) => {
                console.log(data);
            }
        });
        $("#openAddModalForm").click(() => {
            $('#modalAddForm').modal({
                keyboard: false,
                backdrop:"static"
            })
            $("#description").val("");
            $("#modules").val("");
            $("#appid").val(""); 
            $("#key").val("");
        });
    })
</script>
<script type="text/javascript"> //Добавление------------------------------------------------------------------------------------------------------------------------------------------
    $(document).ready(() => {
        $(".addRecord").click(async () => {
            try
            {
                let j = 0;
                let num = 0;
                if($("#description").val() != "" && $("#modules").val() != "" && $("#appid").val() != "" && $("#key").val() != "")
                {
                    let dataPOST = 0;
                    await $.ajax({
                        url: "API/getRecords.php",
                        method: "POST",
                        dataType: "JSON",
                        data:"1",
                        success:(data) => {
                            while(true)
                            {
                                if(Object.keys(data).length == 0)
                                {
                                    j++;
                                    break;
                                }
                                else
                                {
                                    if (j+1 in data)
                                    {
                                        j++;
                                        num++;
                                    }
                                    else
                                    {
                                        j++;
                                    }
                                }
                                if (num == Object.keys(data).length)
                                {
                                    j++;
                                    break;
                                }
                            }
                            dataPOST = data.length == 0 ? {} : data;
                            //console.log(dataPOST);
                            dataPOST[j] = ""+j;
                            dataPOST[j] = {appid:$("#appid").val(),key:$("#key").val(),description:$("#description").val(),modules:$("#modules").val()}
                            //console.log(data);
                        },
                        failure:(data) => {
                            console.log(data);
                        }
                    });
                    await $.ajax({
                        url: "API/addRecords.php",
                        method: "POST",
                        dataType: "JSON",
                        data: dataPOST,
                        success:(data) => {
                            console.log(data);
                        },
                        failure:(data) => {
                            console.log(data);
                        }
                    });
                }
            }
            catch (error)
            {
                document.location.reload();
                console.log('Error',error);
            }
            
        });
    })
</script>
<script type="text/javascript"> //Изменение-------------------------------------------------------------------------------------------------------------------------------------------
    $(document).ready(() => {
        $(".changeRecord").click(async () => {
            try
            {
                let j = $("#num").val();
                if($("#descriptionC").val() != "" && $("#modulesC").val() != "" && $("#appidC").val() != "" && $("#keyC").val() != "")
                {
                    let dataPOST = 0;
                    await $.ajax({
                        url: "API/getRecords.php",
                        method: "POST",
                        dataType: "JSON",
                        data:"1",
                        success:(data) => {
                            dataPOST = data;
                            dataPOST[j] = ""+j;
                            dataPOST[j] = {appid:$("#appidC").val(),key:$("#keyC").val(),description:$("#descriptionC").val(),modules:$("#modulesC").val()}
                            console.log(data);
                        },
                        failure:(data) => {
                            console.log(data);
                        }
                    });
                    await $.ajax({
                        url: "API/addRecords.php",
                        method: "POST",
                        dataType: "JSON",
                        data: dataPOST,
                        success:(data) => {
                            console.log(data);
                        },
                        failure:(data) => {
                            console.log(data);
                        }
                    });
                }
            }
            catch (error)
            {
                document.location.reload();
            }
            
        });
    })
</script>
<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");



?>