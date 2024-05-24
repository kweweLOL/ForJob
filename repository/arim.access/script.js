/*let api = 'test.json';

let modules = [];

fetch(api).then(res => res.json()).then(data =>{
    data.array.forEach(line => {
        modules.push(...line);
    });
});

function getOptions(input, modules)
{
    return modules.filter(s => {
        //сопоставление введённой информации с значениями из массива
        return s.name.match()
    });
}*/

let inputModules = document.querySelector('#modules');
let selectModules = document.querySelector('#modulesselect');

function znachSelect() 
{
    document.getElementById('modules').innerHTML = inputModules.value+', '+selectModules.value;
    alert("Привет, мир!");
}

/*$.ajax({

}).done(() => {
    $(this).addClass
})*/