@extends('layout')

@section('content')
<div class="p-6">
    <h1 class="text-2xl my-6">{{ __("Dashboard") }}</h1>
    <hr />
    <h2 class="text-xl my-6">本週業績</h2>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="dark:bg-gray-300 lg:p-6" >
            <h3>總業績</h3>
            <canvas id="myChart1"></canvas>
        </div>
        <div class="dark:bg-gray-300 lg:p-6">
            <h3>分店業績</h3>
            <canvas id="myChart2"></canvas>
        </div>
        <div class="dark:bg-gray-300 lg:p-6 lg:col-span-2">

            <h3>分店訂單總數</h3>
            <canvas id="myChart3"></canvas>
        </div>
    </div>

    <h2 class="text-xl my-6">食品統計</h2>
    <div class="grid lg:grid-cols-3  gap-6">
        <div class="dark:bg-gray-300 ">
            <h3>熱賣食品</h3>
            <canvas id="myChart4"></canvas>
        </div>
        <div class="dark:bg-gray-300">
            <h3>最少賣出食品</h3>
            <canvas id="myChart5"></canvas>
        </div>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart1');
    var data  = [];
    for(var x=1; x<=6; x++ ){
        data.push(parseInt(Math.random()*100000));
    }

    new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['12/5', '13/5', '14/5', '15/5', '16/5', '17/5'],
        datasets: [{
        label: "#當日所有店總營收HKD",
        data: data,
        borderWidth: 1
        }]
    },
    options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
    });
</script>


<script>
    const ctx2 = document.getElementById('myChart2');
    var data  = [10, 20, 30, 8, 12, 20];


    new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['北角', '荃灣', '太古城', '屯門', '沙田', '馬鞍山'],
        datasets: [{
        label: "#分店百分比",
        data: data,
        borderWidth: 1
        }]
    },
    options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
    });



    const ctx3 = document.getElementById('myChart3');
    var data  = [];
    for(var x=1; x<=6; x++ ){
        data.push(parseInt(Math.random()*10000));
    }


    new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['北角', '荃灣', '太古城', '屯門', '沙田', '馬鞍山'],
        datasets: [{
        label: "#分店訂單數量",
        data: data,
        borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
        scales: {
            y: {
                beginAtZero: true

            }
        }
    }
    });

    const ctx4 = document.getElementById('myChart4');
    var data  = [];
    for(var x=1; x<=5; x++ ){
        data.push(parseInt(Math.random()*100000));
    }
    new Chart(ctx4, {
    type: 'bar',
    data: {
        labels: ['沙爹牛河', '星州炒米', '炸雞肶', '豆腐火腩飯', '椒鹽排骨飯'],
        datasets: [{
        label: "總數",
        data: data,
        borderWidth: 1
        }]
    },
    options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
    });
</script>

<script>
    const ctx5 = document.getElementById('myChart5');
    var data  = [];
    for(var x=1; x<=5; x++ ){
        data.push(parseInt(Math.random()*10));
    }
    new Chart(ctx5, {
    type: 'bar',
    data: {
        labels: ['雞肉沙律', '菜脯蒸蛋', '苦瓜炒蛋', '咖哩薯仔雞翼','冬瓜蒸肉餅'],
        datasets: [{
        label: "總數",
        data: data,
        borderWidth: 1
        }]
    },
    options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
    });

var title = "Hello";
const text = `HEY! Your task "${title}" is now overdue`;
const notification = new Notification("To do list", {body: text});


</script>

@stop


