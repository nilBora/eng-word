$(function() {
    var values = $('#morris-area-chart').data('values');

    var dataLine = Array();
    values.forEach(function(i){
        var date = i.cdate.split('-');
       
        dataLine.push({
            date: i.cdate,
            money: i.cash
        });
    });
    //console.log(dataLine);
    Morris.Line({
        element: 'morris-area-chart',
        data: dataLine,
        xkey: 'date',
        ykeys: ['money'],
        labels: ['money'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
   
   
    var valuesDonut = $('#morris-donut-chart').data('values');
    var dataDonut = Array();
    $.each(valuesDonut, function(index, value) {
        dataDonut.push({
            label: value.category,
            value:  value.cash
        });
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: dataDonut,
        resize: true
    });


    values = $('#morris-bar-chart').data('values');
   
    var dataBar = Array();
    var sumCategoty;
    $.each(values, function(index, value) {
        var settings = Array();
        settings.y = index;
        $.each(value, function(i, v) {
            sumCategoty = 0; 
            if (settings[v.category]) {
                sumCategoty = settings[v.category];
            }
            settings[v.category] = parseFloat(v.cash) + sumCategoty;    
        });
        
        dataBar.push(settings);
        
    }); 
    
    //console.log(dataBar);
    Morris.Bar({
        element: 'morris-bar-chart',
        data: dataBar,
        xkey: 'y',
        ykeys: ['lunch', 'coffe'],
        labels: ['lunch', 'coffe'],
        hideHover: 'auto',
        resize: true
    });
    
});
