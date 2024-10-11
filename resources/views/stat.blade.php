@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Подключение вашего JavaScript файла -->
<script src="{{ asset('js/stats.js') }}"></script>
@section('content')
<div class="max-w-screen-2xl w-full h-auto mx-auto my-0 mb-20">
    <div class="flex justify-between pt-20">
        <h1 class="text-3xl font-bold text-gray-900">Статистика</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
        <!-- Общее количество постов -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900">Общее количество постов</h2>
            <p class="text-4xl font-bold text-blue-600 mt-4">{{ $totalPosts }}</p>
        </div>

        <!-- Средняя оценка -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900">Средняя оценка</h2>
            <p class="text-4xl font-bold text-yellow-500 mt-4">{{ number_format($averageRating, 1) }}</p>
        </div>

        <!-- Общее количество комментариев -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900">Общее количество комментариев</h2>
            <p class="text-4xl font-bold text-green-600 mt-4">{{ $totalComments }}</p>
        </div>

        <!-- Общее количество пользователей -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900">Общее количество пользователей</h2>
            <p class="text-4xl font-bold text-purple-600 mt-4">{{ $totalUsers }}</p>
        </div>

        <!-- Общее количество просмотров -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900">Общее количество просмотров</h2>
            <p class="text-4xl font-bold text-red-600 mt-4">{{ $totalViews }}</p>
        </div>

        <!-- Общее количество просмотров страниц -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900">Общее количество просмотров страниц</h2>
            <p class="text-4xl font-bold text-blue-600 mt-4">{{ $analyticsData['pageViews'] }}</p>
        </div>

        <!-- Общее количество кликов по ссылкам -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900">Общее количество кликов по ссылкам</h2>
            <p class="text-4xl font-bold text-green-600 mt-4">{{ $analyticsData['linkClicks'] }}</p>
        </div>

        <!-- Общее количество времени на сайте -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900">Общее количество времени на сайте</h2>
            <p class="text-4xl font-bold text-purple-600 mt-4">{{ $analyticsData['timeOnSite'] }}</p>
        </div>
    </div>

    <!-- Графики -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Графики</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- График количества постов по месяцам -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900">Количество постов по месяцам</h3>
                <canvas id="postsChart"></canvas>
            </div>

            <!-- График количества комментариев по месяцам -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900">Количество комментариев по месяцам</h3>
                <canvas id="commentsChart"></canvas>
            </div>

            <!-- График количества просмотров страниц -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900">Количество просмотров страниц</h3>
                <canvas id="pageViewsChart"></canvas>
            </div>

            <!-- График количества кликов по ссылкам -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900">Количество кликов по ссылкам</h3>
                <canvas id="linkClicksChart"></canvas>
            </div>

            <!-- График количества времени на сайте -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900">Количество времени на сайте</h3>
                <canvas id="timeOnSiteChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- JavaScript код -->
<script>
    // Данные для графиков
    const postsData = {!! json_encode($postsByMonth) !!};
    const commentsData = {!! json_encode($commentsByMonth) !!};
    const analyticsData = {!! json_encode($analyticsData) !!};

    // График количества постов по месяцам
    const postsChart = new Chart(document.getElementById('postsChart'), {
        type: 'line',
        data: {
            labels: postsData.labels,
            datasets: [{
                label: 'Количество постов',
                data: postsData.data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
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

    // График количества комментариев по месяцам
    const commentsChart = new Chart(document.getElementById('commentsChart'), {
        type: 'bar',
        data: {
            labels: commentsData.labels,
            datasets: [{
                label: 'Количество комментариев',
                data: commentsData.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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

    // График количества просмотров страниц
    const pageViewsChart = new Chart(document.getElementById('pageViewsChart'), {
        type: 'bar',
        data: {
            labels: ['Просмотры страниц'],
            datasets: [{
                label: 'Количество просмотров',
                data: [analyticsData.pageViews],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
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

    // График количества кликов по ссылкам
    const linkClicksChart = new Chart(document.getElementById('linkClicksChart'), {
        type: 'bar',
        data: {
            labels: ['Клик по ссылкам'],
            datasets: [{
                label: 'Количество кликов',
                data: [analyticsData.linkClicks],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
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

    // График количества времени на сайте
    const timeOnSiteChart = new Chart(document.getElementById('timeOnSiteChart'), {
        type: 'bar',
        data: {
            labels: ['Время на сайте'],
            datasets: [{
                label: 'Количество записей',
                data: [analyticsData.timeOnSite],
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
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
@endsection