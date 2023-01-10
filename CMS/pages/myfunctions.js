google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(getData);

function getData(){
    var final=[['Device', 'Acesses']];
    const url="../../acesses/index.php"
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
       let resp = JSON.parse(this.responseText);
       for(let i=0; i<resp.length;i++){
           let arr = [resp[i]['deviceType'], resp[i]['num_devices']];
           final.push(arr);
       }
        var data = google.visualization.arrayToDataTable(final);

        var options = {
            title:'Did you now how many diferent devices acess your page?'
        };

        var chart = new google.visualization.PieChart(document.getElementById('myChart'));
        chart.draw(data, options);
    }
    xhttp.open("GET", url);
    xhttp.send();
}
