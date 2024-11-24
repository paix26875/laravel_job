<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            const fetchProgress = () => {
                fetch('/api/progress')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (!data.totalJobCount) {
                            document.getElementById('jobProgress').innerText = 'Jobがありません';
                            return;
                        }
                        document.getElementById('jobProgress').innerText = data.totalJobCount - (data.waitingJobCount + data.wipJobCount) + ' / ' + data.totalJobCount;
                        document.getElementById('jobProgressPercent').innerText = (data.totalJobCount - (data.waitingJobCount + data.wipJobCount)) / data.totalJobCount * 100 + ' %';
                    }).catch(error => {
                        console.error('Error:', error);
                });
            }
            window.onload = function () {
                fetchProgress()
                document.getElementById('get-progress').addEventListener('click', fetchProgress);
            }
        </script>
    </head>
    <body>
        <main class="m-6">
            <div>
                <a href="{{route('horizon.index')}}">
                    Horizonのページへ
                </a>
                <div class="flex flex-col gap-6">
                    <div>
                        <h2>Jobの操作</h2>
                        <div class="flex flex-col gap-2">
                            <a href="{{route('enqueue')}}" class="px-3 py-2 dark:bg-blue-500 text-white rounded-full text-center">キューイング</a>
                            <a href="{{route('reset')}}" class="px-3 py-2 dark:bg-blue-500 text-white rounded-full text-center">リセット</a>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h2>Jobの進行状況</h2>
                        <button  class="px-3 py-2 dark:bg-blue-500 text-white rounded-full text-center" id="get-progress">更新</button>

                        <div class="flex flex-col gap-2">
                            <p id="jobProgress"></p>
                            <p id="jobProgressPercent"></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
